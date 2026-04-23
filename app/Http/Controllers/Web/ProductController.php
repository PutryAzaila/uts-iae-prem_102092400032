<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->withCount([
                'accounts as available_stock' => fn($q) => 
                    $q->where('status', 'available')
            ])
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}