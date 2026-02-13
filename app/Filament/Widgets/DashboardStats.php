<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $dias = collect(range(6, 0))->map(fn ($day) => now()->subDays($day));

        $faturamentoData = $dias->map(fn ($date) =>
            Order::whereDate('created_at', $date)
                ->where('status', 'concluido')
                ->sum('total')
        )->toArray();

        $faturamentoTotal = Order::where('status', 'concluido')->sum('total');

        $pedidosData = $dias->map(fn ($date) =>
            Order::whereDate('created_at', $date)->count()
        )->toArray();

        $totalPedidos = Order::count();

        $estoqueBaixo = Produto::where('estoque', '<=', 5)->count();
        $totalProdutos = Produto::count();

        return [
            Stat::make('Faturamento', 'R$ ' . number_format($faturamentoTotal, 2, ',', '.'))
                ->description('Últimos 7 dias')
                ->chart($faturamentoData)
                ->color('success'),

            Stat::make('Pedidos', $totalPedidos)
                ->description('Total de pedidos')
                ->chart($pedidosData)
                ->color('primary'),

            Stat::make('Estoque Crítico', $estoqueBaixo)
                ->description('Produtos com estoque baixo')
                ->color($estoqueBaixo > 0 ? 'danger' : 'success'),

            Stat::make('Produtos', $totalProdutos)
                ->description('No catálogo')
                ->color('info'),
        ];
    }
}
