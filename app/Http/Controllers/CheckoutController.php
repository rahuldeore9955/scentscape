<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Auth\EmailOtpController;
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
        if (! Auth::user()->addresses()->exists()) {
            return response()->json(['redirect' => route('dashboard.profile')]);
        }
        $data = $request->validate(['product_id' => ['required', 'integer', 'exists:products,id'], 'quantity' => ['nullable', 'integer', 'min:1', 'max:10']]);
        $order = $this->createOrder(Auth::user(), Product::where('status', 'active')->findOrFail($data['product_id']), $data['quantity'] ?? 1);
        return response()->json(['redirect' => route('checkout.pay', $order)]);
    }

    public function guest(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'digits:10'],
            'password' => ['required', 'confirmed', 'min:6'],
            'terms' => ['accepted'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'state' => ['required', 'string', Rule::in($this->states())],
            'city' => ['required', 'string', Rule::in($this->citiesFor($request->input('state')))],
            'pincode' => ['required', 'string', 'max:20'],
        ]);

        Product::where('status', 'active')->findOrFail($data['product_id']);

        $request->session()->put('registration_otp', [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'checkout' => [
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'address' => [
                    'label' => 'home',
                    'full_name' => $data['name'],
                    'phone' => $data['phone'],
                    'address_line1' => $data['address_line1'],
                    'address_line2' => $data['address_line2'] ?? null,
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'pincode' => $data['pincode'],
                    'country' => 'India',
                    'is_default' => true,
                ],
            ],
        ]);

        try {
            app(EmailOtpController::class)->sendRegistrationOtp($request);
        } catch (\Throwable $exception) {
            report($exception);
            return response()->json(['message' => 'We could not send the verification email. Please try again shortly.'], 502);
        }

        return response()->json(['message' => 'Verification code sent.']);
    }

    public function verifyGuest(Request $request)
    {
        $data = $request->validate(['otp' => ['required', 'digits:6']]);
        $pending = $request->session()->get('registration_otp');

        if (! $pending || ! isset($pending['checkout'], $pending['expires_at'], $pending['code'])
            || now()->timestamp > $pending['expires_at'] || ! Hash::check($data['otp'], $pending['code'])) {
            return response()->json(['message' => 'The verification code is invalid or has expired.'], 422);
        }

        if (User::where('email', $pending['email'])->exists()) {
            $request->session()->forget('registration_otp');
            return response()->json(['message' => 'An account already exists for this email. Please sign in.'], 422);
        }

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'phone' => $pending['phone'],
            'password' => $pending['password'],
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();
        $user->addresses()->create($pending['checkout']['address']);

        Auth::login($user);
        $request->session()->forget('registration_otp');
        $request->session()->regenerate();

        try {
            $product = Product::where('status', 'active')->findOrFail($pending['checkout']['product_id']);
            $order = $this->createOrder($user, $product, $pending['checkout']['quantity']);
        } catch (\Throwable $exception) {
            report($exception);
            return response()->json(['message' => 'Your account was created, but payment could not be started. Please try buying again.'], 502);
        }

        return response()->json(['redirect' => route('checkout.pay', $order)]);
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
        abort_unless($order->payment_status === 'paid', 404);
        $order->loadMissing(['items.product', 'user']);
        return view('checkout.thankyou', compact('order'));
    }

    public function invoice(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($order->payment_status === 'paid', 404);
        $order->loadMissing(['items.product', 'user']);

        $pdf = $this->makeInvoicePdf($order);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ScentScape-Invoice-'.$order->order_number.'.pdf"',
            'Content-Length' => (string) strlen($pdf),
        ]);
    }

    /** Generate a compact, text-only A5 portrait invoice without a PDF package. */
    private function makeInvoicePdf(Order $order): string
    {
        $address = $order->shipping_address ?? [];
        $lines = [
            ['SCENTSCAPE', 22, 552],
            ['INVOICE', 14, 522],
            ['Order number: '.$order->order_number, 10, 504],
            ['Date: '.$order->updated_at->format('d M Y, h:i A'), 10, 490],
            ['Payment: Paid via Razorpay', 10, 476],
            ['', 10, 462],
            ['BILL TO', 11, 448],
            [$order->user->name, 10, 434],
            [$order->user->email, 10, 420],
            [$address['phone'] ?? $order->user->phone ?? '', 10, 406],
            ['', 10, 392],
            ['DELIVERY ADDRESS', 11, 378],
        ];

        foreach (array_filter([
            $address['full_name'] ?? null,
            $address['address_line1'] ?? null,
            $address['address_line2'] ?? null,
            trim(implode(', ', array_filter([$address['city'] ?? null, $address['state'] ?? null, $address['pincode'] ?? null]))),
            $address['country'] ?? null,
        ]) as $addressLine) {
            $lines[] = [$addressLine, 10, null];
        }

        $lines[] = ['', 10, null];
        $lines[] = ['ITEMS', 11, null];
        foreach ($order->items as $item) {
            $lines[] = [($item->product?->name ?? 'Product').'  x'.$item->quantity, 10, null];
            $lines[] = ['Rs. '.number_format((float) $item->subtotal, 2), 10, null];
        }
        $lines[] = ['', 10, null];
        $lines[] = ['TOTAL PAID: Rs. '.number_format((float) $order->total_amount, 2), 12, null];
        $lines[] = ['', 10, null];
        $lines[] = ['Thank you for your purchase.', 10, null];
        $lines[] = ['This is a computer-generated invoice.', 8, null];

        $pages = [];
        $page = [];
        $nextY = 552;
        foreach ($lines as [$text, $size, $fixedY]) {
            if ($fixedY !== null) {
                $nextY = $fixedY;
            }
            foreach ($this->wrapInvoiceText((string) $text, 57) as $wrappedLine) {
                if ($nextY < 42) {
                    $pages[] = $page;
                    $page = [];
                    $nextY = 552;
                }
                $page[] = [$wrappedLine, $size, $nextY];
                $nextY -= max(13, $size + 3);
            }
        }
        if ($page) {
            $pages[] = $page;
        }

        $objects = [
            1 => '<< /Type /Catalog /Pages 2 0 R >>',
            2 => '',
            3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pageIds = [];
        foreach ($pages as $index => $pageLines) {
            $pageId = 4 + ($index * 2);
            $contentId = $pageId + 1;
            $pageIds[] = $pageId;
            $stream = "BT\n";
            foreach ($pageLines as [$text, $size, $y]) {
                $stream .= sprintf("/F1 %.1F Tf\n1 0 0 1 36 %.2F Tm\n(%s) Tj\n", $size, $y, $this->escapePdfText($text));
            }
            $stream .= 'ET';
            $objects[$pageId] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 419.53 595.28] /Resources << /Font << /F1 3 0 R >> >> /Contents '.$contentId.' 0 R >>';
            $objects[$contentId] = "<< /Length ".strlen($stream)." >>\nstream\n".$stream."\nendstream";
        }
        $objects[2] = '<< /Type /Pages /Kids ['.implode(' ', array_map(fn ($id) => $id.' 0 R', $pageIds)).'] /Count '.count($pageIds).' >>';
        ksort($objects);

        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [0];
        foreach ($objects as $id => $object) {
            $offsets[$id] = strlen($pdf);
            $pdf .= $id." 0 obj\n".$object."\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= 'xref'."\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach (array_keys($objects) as $id) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$id]);
        }

        return $pdf.'trailer'."\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n".$xref."\n%%EOF";
    }

    private function wrapInvoiceText(string $text, int $width): array
    {
        $wrapped = wordwrap($text, $width, "\n", true);

        return $wrapped === false || $wrapped === '' ? [''] : explode("\n", $wrapped);
    }

    private function escapePdfText(string $text): string
    {
        $text = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text) ?: '';

        return str_replace(['\\', '(', ')', "\r", "\n"], ['\\\\', '\\(', '\\)', '', ''], $text);
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
        $response = Http::timeout(20)->withBasicAuth(config('services.razorpay.key_id'), config('services.razorpay.secret'))->post('https://api.razorpay.com/v1/orders', ['amount' => (int) round($total * 100), 'currency' => 'INR', 'receipt' => $order->order_number]);
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
