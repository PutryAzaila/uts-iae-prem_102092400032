<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->withCount([
                'accounts as available_stock' => fn($q) => 
                    $q->where('status', 'available')
            ])
            ->firstOrFail();

        if ($product->available_stock === 0) {
            return redirect()->route('products.show', $slug)
                ->with('error', 'Stok produk sedang habis.');
        }

        return view('checkout.index', compact('product'));
    }

    public function store(CheckoutRequest $request, string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        try {
            $result = $this->orderService->createOrder(
                array_merge($request->validated(), ['product_id' => $product->id])
            );

            return redirect()->route('orders.show', [
                'order_code'   => $result['order']->order_code,
                'public_token' => $result['order']->public_token,
            ])->with('snap_token', $result['snap_token']);

        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}