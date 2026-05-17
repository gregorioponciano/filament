<?php

return [
    'client_id' => env('EFIPAY_CLIENT_ID'),
    'client_secret' => env('EFIPAY_CLIENT_SECRET'),
    'cert_path' => storage_path(env('EFIPAY_CERT_PATH', 'app/certs/efipay.pem')),
    'chave_path' => storage_path(env('EFIPAY_CHAVE_PATH', 'app/certs/efipay.pem')),
    'pix_key' => env('EFIPAY_PIX_KEY'),
    'sandbox' => filter_var(env('EFIPAY_SANDBOX', true), FILTER_VALIDATE_BOOLEAN),
    'webhook_token' => env('EFIPAY_WEBHOOK_TOKEN'),

    'pix_base_uri' => filter_var(env('EFIPAY_SANDBOX', true), FILTER_VALIDATE_BOOLEAN)
        ? 'https://pix-h.api.efipay.com.br'
        : 'https://pix.api.efipay.com.br',

    'cob_base_uri' => filter_var(env('EFIPAY_SANDBOX', true), FILTER_VALIDATE_BOOLEAN)
        ? 'https://cobrancas-h.api.efipay.com.br'
        : 'https://cobrancas.api.efipay.com.br',
];
