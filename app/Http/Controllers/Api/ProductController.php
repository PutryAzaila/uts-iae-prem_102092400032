<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::where('is_active', true)
            ->withCount(['accounts as available_stock' => fn($q) => $q->where('status', 'available')])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $products,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->withCount(['accounts as available_stock' => fn($q) => $q->where('status', 'available')])
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data'   => $product,
        ]);
    }
}