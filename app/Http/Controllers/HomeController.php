<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')
            ->orderByDesc('created_at')
            ->get();

        return view('home', compact('featuredProducts'));
    }
}
