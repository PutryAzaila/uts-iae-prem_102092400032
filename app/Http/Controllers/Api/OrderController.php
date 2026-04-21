<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function store(CheckoutRequest $request): JsonResponse
    {
        try {
            $result = $this->orderService->createOrder($request->validated());

            return response()->json([
                'status'  => 'success',
                'message' => 'Order berhasil dibuat.',
                'data'    => [
                    'order_code'   => $result['order']->order_code,
                    'public_token' => $result['order']->public_token,
                    'total_amount' => $result['order']->total_amount,
                    'snap_token'   => $result['snap_token'],
                    'expired_at'   => $result['order']->expired_at,
                ],
            ], 201);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function show(string $orderCode, string $publicToken): JsonResponse
    {
        $order = Order::where('order_code', $orderCode)
            ->where('public_token', $publicToken)
            ->with(['product', 'payment'])
            ->firstOrFail();

        $data = [
            'order_code'     => $order->order_code,
            'status'         => $order->status->value,
            'customer_name'  => $order->customer_name,
            'product'        => [
                'name'  => $order->product->name,
                'price' => $order->total_amount,
            ],
            'payment' => $order->payment ? [
                'payment_type'       => $order->payment->payment_type,
                'transaction_status' => $order->payment->transaction_status,
                'paid_at'            => $order->payment->paid_at,
            ] : null,
            'account' => null, 
        ];

        if ($order->isPaid() && $order->product_account_id) {
            $account = $order->productAccount->makeCredentialsVisible();
            $data['account'] = [
                'username_or_email' => $account->account_email_or_username,
                'password'          => $account->account_password,
                'notes'             => $account->notes,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}