<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['product', 'payment'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_code', 'like', "%{$request->search}%")
                  ->orWhere('customer_name', 'like', "%{$request->search}%")
                  ->orWhere('customer_phone', 'like', "%{$request->search}%");
            });
        }

        $orders = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'status' => 'success',
            'data'   => $orders,
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load(['product', 'payment', 'productAccount']);

        if ($order->productAccount) {
            $order->productAccount->makeCredentialsVisible();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $order,
        ]);
    }
}