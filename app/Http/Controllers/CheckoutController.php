<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function start(Request $request)
    {
        abort_unless(Auth::check(), 401);
        $data = $request->validate(['product_id' => ['required', 'integer', 'exists:products,id'], 'quantity' => ['nullable', 'integer', 'min:1', 'max:10']]);
        $order = $this->createOrder(Auth::user(), Product::where('status', 'active')->findOrFail($data['product_id']), $data['quantity'] ?? 1);
        return response()->json(['redirect' => route('checkout.pay', $order)]);
    }

    public function guest(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'], 'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255', 'unique:users,email'], 'password' => ['required', 'confirmed', 'min:6'],
            'phone' => ['required', 'digits:10'], 'address_line1' => ['required', 'string', 'max:255'], 'state' => ['required', 'string', 'max:100', Rule::in($this->states())], 'city' => ['required', 'string', 'max:100', Rule::in($this->citiesFor($request->input('state')))], 'pincode' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password']), 'phone' => $data['phone']]);
        Address::create(['user_id' => $user->id, 'label' => 'home', 'full_name' => $data['name'], 'phone' => $data['phone'], 'address_line1' => $data['address_line1'], 'city' => $data['city'], 'state' => $data['state'], 'pincode' => $data['pincode'], 'country' => 'India', 'is_default' => true]);
        Auth::login($user);

        $order = $this->createOrder($user, Product::where('status', 'active')->findOrFail($data['product_id']), $data['quantity'] ?? 1);
        return redirect()->route('checkout.pay', $order);
    }

    public function pay(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_if(!$order->razorpay_order_id, 404);
        return view('checkout.pay', compact('order'));
    }

    public function verify(Request $request, Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $data = $request->validate(['razorpay_payment_id' => ['required', 'string'], 'razorpay_order_id' => ['required', 'string'], 'razorpay_signature' => ['required', 'string']]);
        $expected = hash_hmac('sha256', $order->razorpay_order_id.'|'.$data['razorpay_payment_id'], (string) config('services.razorpay.secret'));
        abort_unless(hash_equals($expected, $data['razorpay_signature']) && hash_equals($order->razorpay_order_id, $data['razorpay_order_id']), 403);
        $order->update(['status' => 'processing', 'payment_status' => 'paid', 'razorpay_payment_id' => $data['razorpay_payment_id'], 'razorpay_signature' => $data['razorpay_signature']]);
        return redirect()->route('checkout.thankyou', $order);
    }

    public function thankyou(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        return view('checkout.thankyou', compact('order'));
    }

    private function createOrder(User $user, Product $product, int $quantity): Order
    {
        abort_if(!config('services.razorpay.key_id') || !config('services.razorpay.secret'), 503, 'Razorpay test keys are not configured.');
        $total = (float) $product->price * $quantity;
        $address = $user->addresses()->where('is_default', true)->first() ?: $user->addresses()->latest()->first();
        $shippingAddress = $address ? [
            'label' => $address->label,
            'full_name' => $address->full_name,
            'phone' => $address->phone,
            'address_line1' => $address->address_line1,
            'address_line2' => $address->address_line2,
            'city' => $address->city,
            'state' => $address->state,
            'pincode' => $address->pincode,
            'country' => $address->country,
        ] : null;
        $order = Order::create(['user_id' => $user->id, 'order_number' => 'SCN-'.strtoupper(Str::random(10)), 'status' => 'pending', 'total_amount' => $total, 'shipping_address' => $shippingAddress, 'payment_method' => 'razorpay', 'payment_status' => 'pending']);
        $response = Http::withBasicAuth(config('services.razorpay.key_id'), config('services.razorpay.secret'))->post('https://api.razorpay.com/v1/orders', ['amount' => (int) round($total * 100), 'currency' => 'INR', 'receipt' => $order->order_number]);
        if ($response->failed()) { $order->delete(); abort(502, 'Unable to create the Razorpay order.'); }
        $order->update(['razorpay_order_id' => $response->json('id')]);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => $quantity, 'unit_price' => $product->price, 'subtotal' => $total]);
        return $order;
    }

    private function states(): array
    {
        return array_keys(config('locations.india'));
    }

    private function citiesFor(?string $state): array
    {
        return config('locations.india.'.$state, []);
    }
}
