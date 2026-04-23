<?php
return [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'timeout'       => env('MIDTRANS_TIMEOUT', 15),
    'connect_timeout' => env('MIDTRANS_CONNECT_TIMEOUT', 8),
    'validate_webhook_signature' => env('MIDTRANS_VALIDATE_WEBHOOK_SIGNATURE', true),
];