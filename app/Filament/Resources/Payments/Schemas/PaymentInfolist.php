<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID')
                    ->placeholder('-'),

                TextEntry::make('user.name')
                    ->label('Usuário')
                    ->placeholder('-'),

                TextEntry::make('order_id')
                    ->label('Pedido #')
                    ->placeholder('-'),

                TextEntry::make('transaction_id')
                    ->label('ID Transação Efí Pay')
                    ->placeholder('-')
                    ->copyable(),

                TextEntry::make('payment_method')
                    ->label('Método')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pix' => 'success',
                        'credit_card' => 'warning',
                        'boleto' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pix' => 'PIX',
                        'credit_card' => 'Cartão de Crédito',
                        'boleto' => 'Boleto',
                        default => ucfirst($state),
                    }),

                TextEntry::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->placeholder('-'),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        'refunded' => 'info',
                        'expired' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Pago',
                        'pending' => 'Pendente',
                        'cancelled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                        'expired' => 'Expirado',
                        default => ucfirst($state),
                    }),

                TextEntry::make('discount_amount')
                    ->label('Desconto (Cupom)')
                    ->money('BRL')
                    ->placeholder('-')
                    ->visible(fn ($record) => $record && $record->discount_amount > 0),

                TextEntry::make('points_discount')
                    ->label('Desconto (Pontos)')
                    ->money('BRL')
                    ->placeholder('-')
                    ->visible(fn ($record) => $record && $record->points_discount > 0),

                TextEntry::make('pix_qr_code')
                    ->label('QR Code (Copia e Cola)')
                    ->placeholder('-')
                    ->copyable()
                    ->visible(fn ($record) => $record && $record->payment_method === 'pix'),

                TextEntry::make('boleto_url')
                    ->label('URL do Boleto')
                    ->placeholder('-')
                    ->url(fn ($record) => $record?->boleto_url)
                    ->visible(fn ($record) => $record && $record->payment_method === 'boleto'),

                TextEntry::make('boleto_barcode')
                    ->label('Código de Barras')
                    ->placeholder('-')
                    ->copyable()
                    ->visible(fn ($record) => $record && $record->payment_method === 'boleto'),

                TextEntry::make('paid_at')
                    ->label('Data do Pagamento')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('expires_at')
                    ->label('Data de Expiração')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->placeholder('-'),

                // Pontos de fidelidade concedidos neste pagamento
                TextEntry::make('fidelidadeLogs')
                    ->label('Pontos de Fidelidade')
                    ->formatStateUsing(function ($record): string {
                        if (!$record || $record->fidelidadeLogs->isEmpty()) {
                            return 'Nenhum';
                        }
                        $total = $record->fidelidadeLogs->sum('points');
                        return "{$total} pontos concedidos";
                    })
                    ->visible(fn ($record) => $record && $record->fidelidadeLogs()->exists()),
            ]);
    }
}
