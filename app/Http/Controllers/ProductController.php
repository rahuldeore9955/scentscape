<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        $products = $query->orderByDesc('created_at')->get();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->status === 'active', 404);

        return view('products.show', compact('product'));
    }
}
