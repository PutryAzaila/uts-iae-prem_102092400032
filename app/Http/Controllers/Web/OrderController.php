<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(string $orderCode, string $publicToken)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('public_token', $publicToken)
            ->with(['product', 'payment', 'productAccount'])
            ->firstOrFail();

        $account = null;

        if ($order->isPaid() && $order->productAccount) {
            $account = $order->productAccount->makeCredentialsVisible();
        }

        $snapToken = session('snap_token')
            ?? $order->payment?->snap_token;

        return view('orders.show', compact('order', 'account', 'snapToken'));
    }
}