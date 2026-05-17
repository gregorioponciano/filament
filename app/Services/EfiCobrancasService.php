<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EfiCobrancasService
{
    private string $baseUri;
    private string $clientId;
    private string $clientSecret;
    private string $certPath;
    private string $chavePath;

    public function __construct()
    {
        $this->clientId = config('efipay.client_id');
        $this->clientSecret = config('efipay.client_secret');
        $this->certPath = config('efipay.cert_path');
        $this->chavePath = config('efipay.chave_path');
        $this->baseUri = config('efipay.cob_base_uri');
    }

    public function getAccessToken(): string
    {
        return Cache::remember('efi_cob_access_token', 580, function () {
            $auth = base64_encode("{$this->clientId}:{$this->clientSecret}");

            $response = Http::withOptions([
                'cert' => $this->certPath,
                'ssl_key' => $this->chavePath,
            ])->withHeaders([
                'Authorization' => "Basic {$auth}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUri}/v1/authorize", [
                'grant_type' => 'client_credentials',
            ]);

            if ($response->failed()) {
                Log::error('Efi Cobrancas Auth Error', ['response' => $response->body()]);
                throw new \Exception('Falha ao autenticar com Efí Cobranças: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    private function request(string $method, string $endpoint, array $data = []): array
    {
        $token = $this->getAccessToken();

        $http = Http::withOptions([
            'cert' => $this->certPath,
            'ssl_key' => $this->chavePath,
        ])->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
        ]);

        $response = $http->{$method}("{$this->baseUri}{$endpoint}", $data);

        if ($response->failed()) {
            Log::error('Efi Cobrancas API Error', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            if ($response->status() === 401) {
                Cache::forget('efi_cob_access_token');
            }

            throw new \Exception("Erro na API Cobranças: {$response->body()}");
        }

        return $response->json() ?? [];
    }

    public function criarCobranca(array $items, array $metadata = []): array
    {
        $payload = [
            'items' => $items,
        ];

        if (!empty($metadata)) {
            $payload['metadata'] = $metadata;
        }

        return $this->request('post', '/v1/charge', $payload);
    }

    public function criarCobrancaOneStep(array $data): array
    {
        return $this->request('post', '/v1/charge/one-step', $data);
    }

    public function pagarBoleto(int $chargeId, array $customerData, array $boletoConfig = []): array
    {
        $payload = [
            'payment' => [
                'banking_billet' => array_merge([
                    'customer' => $customerData,
                ], $boletoConfig),
            ],
        ];

        return $this->request('post', "/v1/charge/{$chargeId}/pay", $payload);
    }

    public function pagarCartao(int $chargeId, string $paymentToken, array $customerData, int $installments = 1): array
    {
        $payload = [
            'payment' => [
                'credit_card' => [
                    'customer' => $customerData,
                    'installments' => $installments,
                    'payment_token' => $paymentToken,
                ],
            ],
        ];

        return $this->request('post', "/v1/charge/{$chargeId}/pay", $payload);
    }

    public function consultarCobranca(int $chargeId): array
    {
        return $this->request('get', "/v1/charge/{$chargeId}");
    }

    public function gerarBoletoOneStep(
        array $items,
        array $customerData,
        ?string $notificationUrl = null,
        array $boletoConfig = []
    ): array {
        $payload = [
            'items' => $items,
            'payment' => [
                'banking_billet' => array_merge([
                    'customer' => $customerData,
                    'expire_at' => $boletoConfig['expire_at'] ?? now()->addDays(3)->format('Y-m-d'),
                    'message' => $boletoConfig['message'] ?? '',
                ], $boletoConfig),
            ],
        ];

        if ($notificationUrl) {
            $payload['metadata']['notification_url'] = $notificationUrl;
        }

        return $this->request('post', '/v1/charge/one-step', $payload);
    }

    public function gerarCartaoOneStep(
        array $items,
        array $customerData,
        string $paymentToken,
        int $installments = 1,
        ?string $notificationUrl = null,
        ?string $boletoUrl = null
    ): array {
        $payload = [
            'items' => $items,
            'payment' => [
                'credit_card' => [
                    'customer' => $customerData,
                    'installments' => $installments,
                    'payment_token' => $paymentToken,
                ],
            ],
        ];

        if ($notificationUrl) {
            $payload['metadata']['notification_url'] = $notificationUrl;
        }

        return $this->request('post', '/v1/charge/one-step', $payload);
    }

    public function cancelarCobranca(int $chargeId): array
    {
        return $this->request('put', "/v1/charge/{$chargeId}/cancel");
    }

    public function listarParcelas(string $brand, int $total): array
    {
        return $this->request('get', "/v1/installments?brand={$brand}&total={$total}");
    }
}
