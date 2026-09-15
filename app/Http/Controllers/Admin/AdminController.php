<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\AuditLog;
use App\Services\AuditLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();

        $stats = [
            'products' => Product::count(),
            'users' => User::where('is_admin', false)->count(),
            'orders' => Order::count(),
            'paid_total' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.index', compact('stats', 'recentOrders'));
    }

    public function products()
    {
        $this->ensureAdmin();

        return view('admin.products.index', ['products' => Product::latest()->get()]);
    }

    public function createProduct()
    {
        $this->ensureAdmin();

        return view('admin.products.form', ['product' => new Product()]);
    }

    public function storeProduct(Request $request)
    {
        $this->ensureAdmin();
        $product = Product::create($this->productData($request));
        app(AuditLogger::class)->record('product.created', $product, $product->name);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        $this->ensureAdmin();

        return view('admin.products.form', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->ensureAdmin();
        $product->update($this->productData($request, $product));
        app(AuditLogger::class)->record('product.updated', $product, $product->name, ['changes' => $this->changesFor($product, $product->getChanges())]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroyProduct(Product $product)
    {
        $this->ensureAdmin();
        app(AuditLogger::class)->record('product.deleted', $product, $product->name, ['snapshot' => $product->only(['sku', 'price', 'status'])]);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product removed from the catalog.');
    }

    public function users()
    {
        $this->ensureAdmin();
        $users = User::where('is_admin', false)->withCount('orders')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $this->ensureAdmin();
        abort_if($user->is_admin, 404);
        $user->load(['addresses' => fn ($query) => $query->orderByDesc('is_default'), 'orders' => fn ($query) => $query->latest()]);

        return view('admin.users.show', compact('user'));
    }

    public function orders()
    {
        $this->ensureAdmin();

        return view('admin.orders.index', ['orders' => Order::with('user')->latest()->get()]);
    }

    public function showOrder(Order $order)
    {
        $this->ensureAdmin();
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $this->ensureAdmin();
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'courier_name' => ['nullable', 'string', 'max:100'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
        $order->update($data);
        app(AuditLogger::class)->record('order.updated', $order, $order->order_number, ['changes' => $this->changesFor($order, $order->getChanges())]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated.');
    }

    public function payments()
    {
        $this->ensureAdmin();

        return view('admin.payments.index', ['payments' => Order::with('user')->whereNotNull('payment_method')->latest()->get()]);
    }

    public function auditLogs(Request $request)
    {
        $this->ensureAdmin();
        $logs = AuditLog::with('user')
            ->when($request->filled('event'), fn ($query) => $query->where('event', $request->string('event')))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.audit.index', compact('logs'));
    }

    private function ensureAdmin(): void
    {
        abort_unless(Auth::user()?->is_admin, 403);
    }

    private function productData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'category' => ['required', Rule::in(['women', 'men', 'unisex'])],
            'badge' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['active', 'draft', 'out_of_stock'])],
            'image' => ['nullable', 'url', 'max:2048'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
            'images_upload' => ['nullable', 'array', 'max:4'],
            'images_upload.*' => ['image', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string', 'max:2048'],
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product?->id)],
        ]);

        $data['slug'] = $this->uniqueSlug(Str::slug($data['name']) ?: 'product', $product);

        if ($request->hasFile('image_upload')) {
            $data['image'] = Storage::disk('public')->url($request->file('image_upload')->store('products', 'public'));
        } elseif ($product && blank($data['image'] ?? null)) {
            unset($data['image']);
        }
        $extraImages = collect($product?->images ?? [])
            ->reject(fn (string $image) => in_array($image, $data['remove_images'] ?? [], true))
            ->values();

        foreach ($request->file('images_upload', []) as $image) {
            $extraImages->push(Storage::disk('public')->url($image->store('products', 'public')));
        }

        if ($extraImages->count() > 4) {
            throw ValidationException::withMessages([
                'images_upload' => 'A product can have a maximum of 4 extra images. Remove an existing image before adding another.',
            ]);
        }

        $data['images'] = $extraImages->isEmpty() ? null : $extraImages->all();
        unset($data['image_upload'], $data['images_upload'], $data['remove_images']);

        return $data;
    }

    private function uniqueSlug(string $base, ?Product $product): string
    {
        $candidate = $base;
        $suffix = 2;

        while (Product::withTrashed()->where('slug', $candidate)->when($product, fn ($query) => $query->whereKeyNot($product->id))->exists()) {
            $candidate = $base.'-'.$suffix++;
        }

        return $candidate;
    }

    private function changesFor(Model $model, array $fields): array
    {
        $changes = [];
        foreach (array_keys($fields) as $field) {
            if (in_array($field, ['updated_at', 'created_at', 'deleted_at'], true) || ! $model->wasChanged($field)) {
                continue;
            }
            $changes[$field] = ['from' => $model->getOriginal($field), 'to' => $model->getAttribute($field)];
        }
        return $changes;
    }
}
