<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EfiPayService
{
    private string $baseUri;
    private string $clientId;
    private string $clientSecret;
    private string $certPath;
    private string $chavePath;
    private string $pixKey;

    public function __construct()
    {
        $this->baseUri = config('efipay.pix_base_uri');
        $this->clientId = config('efipay.client_id');
        $this->clientSecret = config('efipay.client_secret');
        $this->certPath = config('efipay.cert_path');
        $this->chavePath = config('efipay.chave_path');
        $this->pixKey = config('efipay.pix_key');
    }

    public function getAccessToken(): string
    {
        return Cache::remember('efipay_access_token', 3500, function () {
            $auth = base64_encode("{$this->clientId}:{$this->clientSecret}");

            $response = Http::withOptions([
                'cert' => $this->certPath,
                'ssl_key' => $this->chavePath,
            ])->withHeaders([
                'Authorization' => "Basic {$auth}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUri}/oauth/token", [
                'grant_type' => 'client_credentials',
            ]);

            if ($response->failed()) {
                Log::error('Efí Pay Auth Error', ['response' => $response->body()]);
                throw new \Exception('Falha ao autenticar com Efí Bank: ' . $response->body());
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
            Log::error('Efí Pay API Error', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            if ($response->status() === 401) {
                Cache::forget('efipay_access_token');
            }

            throw new \Exception("Erro na API Efí: {$response->body()}");
        }

        return $response->json() ?? [];
    }

    public function criarCobrancaImediata(
        string $cpf,
        string $nomeCliente,
        float $valor,
        string $descricao = '',
        int $expiracao = 3600
    ): array {
        $txid = 'GP' . now()->format('YmdHis') . \Illuminate\Support\Str::random(18);

        $payload = [
            'calendario' => [
                'expiracao' => $expiracao,
            ],
            'devedor' => [
                'cpf' => preg_replace('/\D/', '', $cpf),
                'nome' => $nomeCliente,
            ],
            'valor' => [
                'original' => number_format($valor, 2, '.', ''),
            ],
            'chave' => $this->pixKey,
            'solicitacaoPagador' => $descricao ?: 'Pagamento de pedido',
        ];

        return $this->request('put', "/v2/cob/{$txid}", $payload);
    }

    public function consultarCobranca(string $txid): array
    {
        return $this->request('get', "/v2/cob/{$txid}");
    }

    public function configurarWebhook(string $url): array
    {
        return $this->request('put', "/v2/webhook/{$this->pixKey}", [
            'webhookUrl' => $url,
        ]);
    }

    public function consultarWebhook(): array
    {
        return $this->request('get', "/v2/webhook/{$this->pixKey}");
    }

    public function deletarWebhook(): void
    {
        $this->request('delete', "/v2/webhook/{$this->pixKey}");
    }

    public function gerarEVP(): array
    {
        return $this->request('post', '/v2/gn/evp');
    }

    public function consultarSaldo(): array
    {
        return $this->request('get', '/v2/gn/saldo');
    }

    public function listarPixRecebidos(string $inicio, string $fim): array
    {
        return $this->request('get', "/v2/pix?inicio={$inicio}&fim={$fim}");
    }
}
