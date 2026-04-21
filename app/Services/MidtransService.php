<?php
namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $serverKey;
    private string $snapUrl;
    private bool   $isProduction;

    public function __construct()
    {
        $this->serverKey    = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production', false);
        $this->snapUrl      = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public function createSnapToken(Order $order): string
    {
        $payload = [
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone'      => $order->customer_phone,
                'email'      => $order->customer_email ?? 'noreply@example.com',
            ],
            'item_details' => [
                [
                    'id'       => (string) $order->product_id,
                    'price'    => (int) $order->total_amount,
                    'quantity' => 1,
                    'name'     => $order->product->name,
                ]
            ],
            'expiry' => [
                'unit'     => 'hours',
                'duration' => 24,
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->post($this->snapUrl, $payload);

            if ($response->failed()) {
                Log::error('Midtrans Snap token creation failed', [
                    'order_code' => $order->order_code,
                    'status'     => $response->status(),
                    'body'       => $response->body(),
                    'json'       => $response->json(),
                ]);

                throw new \RuntimeException(
                    'Gagal membuat token pembayaran. Midtrans: ' . $response->body()
                );
            }

        return $response->json('token');
    }

   public function verifyNotificationSignature(array $payload): bool
    {
        if (
            !isset($payload['order_id']) ||
            !isset($payload['status_code']) ||
            !isset($payload['gross_amount'])
        ) {
            throw new \RuntimeException('Payload webhook Midtrans tidak lengkap.');
        }

        $orderId     = $payload['order_id'];
        $statusCode  = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($expected, $payload['signature_key'] ?? '');
    }
    }