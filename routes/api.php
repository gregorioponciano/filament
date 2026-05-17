<?php

/*
|--------------------------------------------------------------------------
| API Routes — Efí Pay Webhook & Integrações
|--------------------------------------------------------------------------
|
| Rotas de API para comunicação com serviços externos.
| O webhook da Efí Pay não precisa de CSRF e utiliza verificação
| de token/IP para segurança.
|
| Documentação Efí Pay:
|   https://dev.efipay.com.br/docs/
|
*/

use App\Http\Controllers\WebhookController;

// =============================================================================
// WEBHOOK EFÍ PAY
// =============================================================================
// A Efí Pay enviará notificações POST para esta URL quando houver
// mudanças no status das cobranças.
//
// Configure no painel da Efí Pay:
//   URL de Notificação: https://seudominio.com/api/webhook/efipay
//
// TODO: INSIRA A URL DO SEU WEBHOOK no .env:
//       EFIPAY_WEBHOOK_URL=/api/webhook/efipay
// =============================================================================

Route::post('/webhook/efipay', [WebhookController::class, 'handle'])
    ->name('webhook.efipay')
    ->middleware(\App\Http\Middleware\VerifyEfiPayWebhook::class);

// Endpoint de verificação (usado pela Efí Pay para testar a URL)
Route::get('/webhook/efipay/verify', [WebhookController::class, 'verify'])
    ->name('webhook.efipay.verify');
