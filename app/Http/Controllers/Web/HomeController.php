<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->withCount([
                'accounts as available_stock' => fn($q) => 
                    $q->where('status', 'available')
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('products'));
    }
}