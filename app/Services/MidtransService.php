<?php
namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $serverKey;
    private string $snapUrl;
    private string $apiBaseUrl;
    private bool   $isProduction;
    private int    $timeout;
    private int    $connectTimeout;

    public function __construct()
    {
        $this->serverKey    = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production', false);
        $this->timeout      = (int) config('midtrans.timeout', 15);
        $this->connectTimeout = (int) config('midtrans.connect_timeout', 8);
        $this->snapUrl      = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $this->apiBaseUrl   = $this->isProduction
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
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

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->connectTimeout($this->connectTimeout)
                ->timeout($this->timeout)
                ->retry(2, 500, fn($e) => $e instanceof ConnectionException, throw: false)
                ->post($this->snapUrl, $payload);
        } catch (ConnectionException $e) {
            Log::error('Midtrans Snap token connection failed', [
                'order_code' => $order->order_code,
                'url'        => $this->snapUrl,
                'error'      => $e->getMessage(),
            ]);

            throw new \RuntimeException(
                'Gagal terhubung ke Midtrans. Periksa koneksi internet / DNS server lalu coba lagi.'
            );
        }

        if (!$response || $response->failed()) {
            Log::error('Midtrans Snap token creation failed', [
                'order_code' => $order->order_code,
                'url'        => $this->snapUrl,
                'status'     => $response?->status(),
                'body'       => $response?->body(),
                'json'       => $response?->json(),
            ]);

            throw new \RuntimeException(
                'Gagal membuat token pembayaran. Midtrans: ' . ($response?->body() ?? 'Tidak ada respons dari server.')
            );
        }

        return $response->json('token');
    }

    public function getTransactionStatus(string $orderCode): array
    {
        $url = "{$this->apiBaseUrl}/{$orderCode}/status";

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->connectTimeout($this->connectTimeout)
                ->timeout($this->timeout)
                ->retry(2, 500, fn($e) => $e instanceof ConnectionException, throw: false)
                ->get($url);
        } catch (ConnectionException $e) {
            Log::error('Midtrans status connection failed', [
                'order_code' => $orderCode,
                'url'        => $url,
                'error'      => $e->getMessage(),
            ]);

            throw new \RuntimeException('Gagal mengambil status transaksi dari Midtrans.');
        }

        if (!$response || $response->failed()) {
            Log::error('Midtrans status request failed', [
                'order_code' => $orderCode,
                'url'        => $url,
                'status'     => $response?->status(),
                'body'       => $response?->body(),
            ]);

            throw new \RuntimeException('Midtrans gagal mengembalikan status transaksi.');
        }

        return $response->json();
    }

    public function verifyNotificationSignature(array $payload): bool
    {
        if (
            !isset($payload['order_id']) ||
            !isset($payload['status_code']) ||
            !isset($payload['gross_amount']) ||
            !isset($payload['signature_key'])
        ) {
            return false;
        }

        $orderId     = (string) $payload['order_id'];
        $statusCode  = (string) $payload['status_code'];
        $grossAmount = (string) $payload['gross_amount'];

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($expected, (string) $payload['signature_key']);
    }
}