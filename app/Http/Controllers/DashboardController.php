<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $address = $user->addresses()->where('is_default', true)->first()
            ?: $user->addresses()->latest()->first();

        return view('dashboard.profile', compact('user', 'address'));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('dashboard.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $data = $this->validateAddress($request);
        $user = Auth::user();

        if ($user->addresses()->doesntExist()) {
            $data['is_default'] = true;
        }

        $user->addresses()->create($data);

        return back()->with('success', 'Address saved successfully.');
    }

    public function makeDefaultAddress(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }

    public function destroyAddress(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $replacement = Auth::user()->addresses()->latest()->first();
            if ($replacement) {
                $replacement->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Address removed.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address_full_name' => ['nullable', 'required_with:address_line1', 'string', 'max:255'],
            'address_phone' => ['nullable', 'required_with:address_line1', 'string', 'max:20'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'required_with:address_line1', 'string', 'max:100'],
            'state' => ['nullable', 'required_with:address_line1', 'string', 'max:100'],
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
            $address = $user->addresses()->where('label', 'home')->first();
            $user->addresses()->update(['is_default' => false]);

            if ($address) {
                $address->update([
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
            } else {
                Address::create([
                    'user_id' => $user->id,
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
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    private function validateAddress(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
        ]);
    }
}
