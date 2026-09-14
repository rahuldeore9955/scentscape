<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $orders = $user->orders()->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'orders'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        return view('dashboard.orders', compact('orders'));
    }

    public function wishlist()
    {
        $wishlist = Auth::user()->wishlist()->paginate(12);
        return view('dashboard.wishlist', compact('wishlist'));
    }

    public function profile()
    {
        $user = Auth::user();
        $address = $this->singleAddress($user);

        return view('dashboard.profile', compact('user', 'address'));
    }

    public function products(Request $request)
    {
        $query = Product::query()
            ->where('status', 'active')
            ->withCount('reviews');

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($products) use ($search) {
                $products->where('name', 'like', '%'.$search.'%')
                    ->orWhere('brand', 'like', '%'.$search.'%');
            });
        }

        $products = $query->latest()->take(4)->get();
        $categories = Product::where('status', 'active')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('dashboard.products', compact('products', 'categories'));
    }

    public function addresses()
    {
        return redirect()->route('dashboard.profile');
    }

    public function storeAddress(Request $request)
    {
        $data = $this->validateAddress($request);
        $user = Auth::user();

        $data['label'] = 'home';
        $data['is_default'] = true;
        $this->saveSingleAddress($user, $data);

        return back()->with('success', 'Address saved successfully.');
    }

    public function makeDefaultAddress(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        Auth::user()->addresses()->where('id', '!=', $address->id)->delete();
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }

    public function destroyAddress(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $address->delete();

        return back()->with('success', 'Address removed.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'digits:10'],
            'address_full_name' => ['nullable', 'required_with:address_line1', 'string', 'max:255'],
            'address_phone' => ['nullable', 'required_with:address_line1', 'digits:10'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'required_with:address_line1', 'string', 'max:100', Rule::in($this->states())],
            'city' => ['nullable', 'required_with:address_line1', 'string', 'max:100', Rule::in($this->citiesFor($request->input('state')))],
            'pincode' => ['nullable', 'required_with:address_line1', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:6'],
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $accountData = collect($validated)->except([
            'address_full_name',
            'address_phone',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'pincode',
            'country',
        ])->all();

        $user->update($accountData);

        if ($request->filled('address_line1')) {
            $this->saveSingleAddress($user, [
                'label' => 'home',
                'full_name' => $request->input('address_full_name', $user->name),
                'phone' => $request->input('address_phone', $user->phone),
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->input('country', 'India'),
                'is_default' => true,
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    private function validateAddress(Request $request): array
    {
        return $request->validate([
            'label' => ['nullable', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:100', Rule::in($this->states())],
            'city' => ['required', 'string', 'max:100', Rule::in($this->citiesFor($request->input('state')))],
            'pincode' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
        ]);
    }

    private function states(): array
    {
        return array_keys(config('locations.india'));
    }

    private function citiesFor(?string $state): array
    {
        return config('locations.india.'.$state, []);
    }

    private function singleAddress($user): ?Address
    {
        $address = $user->addresses()
            ->orderByDesc('is_default')
            ->latest()
            ->first();

        if ($address) {
            $user->addresses()->where('id', '!=', $address->id)->delete();
            $address->update(['is_default' => true]);
        }

        return $address;
    }

    private function saveSingleAddress($user, array $data): Address
    {
        $address = $this->singleAddress($user);

        if ($address) {
            $address->update($data);
            return $address;
        }

        return $user->addresses()->create($data);
    }
}
