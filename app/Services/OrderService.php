<?php
namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function __construct(
        private MidtransService          $midtrans,
        private AccountAssignmentService $accountAssignment
    ) {}

    public function createOrder(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $product = Product::where('id', $data['product_id'])
                ->where('is_active', true)
                ->firstOrFail();

            $stockCount = $product->availableAccounts()->count();
            if ($stockCount === 0) {
                throw new \RuntimeException('Stok produk habis.');
            }

            $order = Order::create([
                'customer_name'  => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'product_id'     => $product->id,
                'total_amount'   => $product->price,
                'status'         => OrderStatus::Pending,
            ]);

            $order->load('product');

            $snapToken = $this->midtrans->createSnapToken($order);

            Payment::create([
                'order_id'  => $order->id,
                'provider'  => 'midtrans',
                'snap_token' => $snapToken,
            ]);

            return [
                'order'      => $order,
                'snap_token' => $snapToken,
            ];
        });
    }
}