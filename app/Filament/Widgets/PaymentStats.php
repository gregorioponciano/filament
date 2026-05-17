<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Widget de estatísticas de pagamento para o dashboard administrativo.
 *
 * Exibe:
 *   - Faturamento total dos últimos 7 dias (pedidos pagos)
 *   - Valor total processado via Efí Pay
 *   - Pagamentos pendentes
 *   - Taxa de conversão
 *   - Métodos de pagamento mais usados
 */
class PaymentStats extends BaseWidget
{
    protected function getStats(): array
    {
        $dias = collect(range(6, 0))->map(fn ($day) => now()->subDays($day));

        // =====================================================================
        // Faturamento (pedidos com status 'pago')
        // =====================================================================
        $faturamentoData = $dias->map(fn ($date) =>
            Order::whereDate('created_at', $date)
                ->where('status', 'pago')
                ->sum('total')
        )->toArray();

        $faturamentoTotal = Order::where('status', 'pago')->sum('total');

        // =====================================================================
        // Estatísticas de pagamentos
        // =====================================================================
        $totalPagamentos    = Payment::count();
        $pagamentosPendentes = Payment::where('status', 'pending')->count();
        $pagamentosPagos    = Payment::where('status', 'paid')->count();
        $valorProcessado    = Payment::where('status', 'paid')->sum('amount');

        // =====================================================================
        // Métodos de pagamento
        // =====================================================================
        $pixCount   = Payment::where('payment_method', 'pix')->where('status', 'paid')->count();
        $boletoCount = Payment::where('payment_method', 'boleto')->where('status', 'paid')->count();
        $cardCount  = Payment::where('payment_method', 'credit_card')->where('status', 'paid')->count();

        // =====================================================================
        // Taxa de conversão
        // =====================================================================
        $taxaConversao = $totalPagamentos > 0
            ? round(($pagamentosPagos / $totalPagamentos) * 100, 1)
            : 0;

        return [
            Stat::make('Faturamento Total (Pedidos)', 'R$ ' . number_format($faturamentoTotal, 2, ',', '.'))
                ->description('Últimos 7 dias — pedidos com status "pago"')
                ->chart($faturamentoData)
                ->color('success'),

            Stat::make('Valor Processado (Efí Pay)', 'R$ ' . number_format($valorProcessado, 2, ',', '.'))
                ->description('Total de pagos via Efí Pay')
                ->color('success'),

            Stat::make('Pagamentos Pendentes', $pagamentosPendentes)
                ->description('Aguardando confirmação')
                ->color($pagamentosPendentes > 0 ? 'warning' : 'success'),

            Stat::make('Taxa de Conversão', $taxaConversao . '%')
                ->description('Pagos / Total de transações')
                ->color($taxaConversao > 50 ? 'success' : 'danger'),

            Stat::make('PIX', $pixCount)
                ->description('Pagamentos via PIX')
                ->color('primary'),

            Stat::make('Boleto', $boletoCount)
                ->description('Boletos pagos')
                ->color('info'),

            Stat::make('Cartão de Crédito', $cardCount)
                ->description('Transações com cartão')
                ->color('warning'),
        ];
    }
}
