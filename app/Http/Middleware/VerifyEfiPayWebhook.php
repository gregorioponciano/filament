<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de segurança para validar requisições de webhook da Efí Pay.
 *
 * Protege o endpoint de webhook verificando:
 * 1. Token de segurança enviado pela Efí Pay (se configurado)
 * 2. Range de IPs autorizados da Efí Pay
 *
 * Isso impede que requisições maliciosas falsifiquem notificações de pagamento.
 */
class VerifyEfiPayWebhook
{
    /**
     * Lista de ranges de IP autorizados da Efí Pay.
     * Atualize conforme documentação oficial.
     */
    private const ALLOWED_IPS = [
        '34.95.0.0/16',
        '35.247.0.0/16',
        '104.196.0.0/16',
        '107.178.0.0/16',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Opção 1: Verificação via Token (recomendado)
        $expectedToken = config('efipay.webhook_token');
        $receivedToken = $request->header('X-EfiPay-Webhook-Token')
            ?? $request->input('token')
            ?? $request->header('Authorization');

        if ($expectedToken) {
            // Remove "Bearer " do token se presente
            $receivedToken = preg_replace('/^Bearer\s+/', '', (string) $receivedToken);

            if ($receivedToken !== $expectedToken) {
                Log::warning('Tentativa de webhook com token inválido', [
                    'ip' => $request->ip(),
                ]);

                return response()->json(['error' => 'Token inválido.'], 401);
            }

            return $next($request);
        }

        // Opção 2: Verificação por IP (fallback se token não configurado)
        $clientIp = $request->ip();

        if (!$this->isIpAllowed($clientIp)) {
            Log::warning('Tentativa de webhook de IP não autorizado', [
                'ip' => $clientIp,
            ]);

            return response()->json(['error' => 'IP não autorizado.'], 403);
        }

        return $next($request);
    }

    /**
     * Verifica se o IP está dentro dos ranges permitidos.
     */
    private function isIpAllowed(string $ip): bool
    {
        foreach (self::ALLOWED_IPS as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se um IP está dentro de um range CIDR.
     */
    private function ipInRange(string $ip, string $range): bool
    {
        if (!str_contains($range, '/')) {
            return $ip === $range;
        }

        [$subnet, $bits] = explode('/', $range);
        $bits = (int) $bits;

        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;

        return ($ip & $mask) === $subnet;
    }
}
