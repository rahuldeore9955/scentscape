<?php

namespace App\Http\Controllers;

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
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:6'],
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
