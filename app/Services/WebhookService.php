<?php
namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function __construct(
        private AccountAssignmentService $accountAssignment
    ) {}

    public function handle(array $payload): void
    {
        $orderCode         = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus       = $payload['fraud_status'] ?? null;
        $transactionId     = $payload['transaction_id'];
        $paymentType       = $payload['payment_type'] ?? null;

        $order = Order::where('order_code', $orderCode)->firstOrFail();

        if ($order->status === OrderStatus::Paid) {
            Log::info("Webhook: Order {$orderCode} sudah paid, skip.");
            return;
        }

        DB::transaction(function () use ($order, $payload, $transactionStatus, $fraudStatus, $transactionId, $paymentType) {
            $newStatus = $this->resolveOrderStatus($transactionStatus, $fraudStatus);

            $order->payment()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id'     => $transactionId,
                    'transaction_status' => $transactionStatus,
                    'payment_type'       => $paymentType,
                    'raw_response'       => $payload,
                    'paid_at'            => $newStatus === OrderStatus::Paid ? now() : null,
                ]
            );

            $order->update(['status' => $newStatus]);

            if ($newStatus === OrderStatus::Paid) {
                $this->accountAssignment->assignToOrder($order);
            }

            if (in_array($newStatus, [OrderStatus::Failed, OrderStatus::Expired, OrderStatus::Cancelled])) {
                $this->accountAssignment->releaseFromOrder($order);
            }

            Log::info("Webhook processed: Order {$order->order_code} → {$newStatus->value}");
        });
    }

    private function resolveOrderStatus(string $transactionStatus, ?string $fraudStatus): OrderStatus
    {
        return match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => OrderStatus::Paid,
            $transactionStatus === 'settlement'                           => OrderStatus::Paid,
            $transactionStatus === 'pending'                              => OrderStatus::Pending,
            $transactionStatus === 'deny'                                 => OrderStatus::Failed,
            $transactionStatus === 'expire'                               => OrderStatus::Expired,
            $transactionStatus === 'cancel'                               => OrderStatus::Cancelled,
            default                                                       => OrderStatus::Pending,
        };
    }
}