<?php

return [
    'enabled' => env('MIDTRANS_ENABLED', true),
    
    // Midtrans Server Key dan Client Key
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    
    // Environment: sandbox atau production
    'environment' => env('MIDTRANS_ENVIRONMENT', 'sandbox'),
    
    // API Base URL (akan auto sesuai dengan environment)
    'api_base_url' => env('MIDTRANS_API_URL'),
    
    // Merchant ID
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    
    // Enabled Payment Methods
    'payment_methods' => [
        'qris' => true,
        'bank_transfer' => true,
        'credit_card' => false,
        'gopay' => false,
    ],
];
