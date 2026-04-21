<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MidtransService;
use App\Services\WebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        private MidtransService $midtrans,
        private WebhookService  $webhook
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Midtrans Webhook received', ['order_id' => $payload['order_id'] ?? null]);

        if (!$this->midtrans->verifyNotificationSignature($payload)) {
            Log::warning('Midtrans: Invalid signature', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        try {
            $this->webhook->handle($payload);
            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage(), ['payload' => $payload]);
            return response()->json(['message' => 'Internal error'], 500);
        }
    }
}