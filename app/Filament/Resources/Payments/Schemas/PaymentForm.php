<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('order_id')
                    ->label('Pedido')
                    ->relationship('order', 'id')
                    ->searchable()
                    ->preload(),

                TextInput::make('transaction_id')
                    ->label('ID Transação Efí Pay')
                    ->maxLength(255),

                Select::make('payment_method')
                    ->label('Método de Pagamento')
                    ->options([
                        'pix' => 'PIX',
                        'credit_card' => 'Cartão de Crédito',
                        'boleto' => 'Boleto Bancário',
                    ])
                    ->required(),

                TextInput::make('amount')
                    ->label('Valor')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'paid' => 'Pago',
                        'cancelled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
                        'expired' => 'Expirado',
                    ])
                    ->required()
                    ->default('pending'),

                TextInput::make('discount_amount')
                    ->label('Desconto (Cupom)')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0),

                TextInput::make('points_discount')
                    ->label('Desconto (Pontos)')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0),
            ]);
    }
}
