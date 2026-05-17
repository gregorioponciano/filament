<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Código do Cupom')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->uppercase()
                    ->helperText('Código que o cliente digitará. Será convertido para maiúsculas.'),

                Select::make('type')
                    ->label('Tipo de Desconto')
                    ->options([
                        'percentage' => 'Percentual (%)',
                        'fixed' => 'Valor Fixo (R$)',
                    ])
                    ->required()
                    ->default('percentage'),

                TextInput::make('value')
                    ->label('Valor do Desconto')
                    ->numeric()
                    ->required()
                    ->helperText('Se percentual, informe apenas o número (ex: 10 para 10%). Se fixo, informe o valor em reais.'),

                TextInput::make('min_order_value')
                    ->label('Valor Mínimo do Pedido')
                    ->numeric()
                    ->prefix('R$')
                    ->helperText('Valor mínimo que o pedido deve ter para usar este cupom (deixe vazio para sem mínimo).'),

                TextInput::make('max_uses')
                    ->label('Limite Total de Usos')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Quantas vezes este cupom pode ser usado no total (deixe vazio para ilimitado).'),

                TextInput::make('max_uses_per_user')
                    ->label('Limite por Usuário')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Quantas vezes cada usuário pode usar este cupom.'),

                Toggle::make('active')
                    ->label('Ativo')
                    ->default(true)
                    ->helperText('Apenas cupons ativos podem ser utilizados.'),

                DateTimePicker::make('starts_at')
                    ->label('Data de Início')
                    ->helperText('A partir de quando o cupom estará disponível.'),

                DateTimePicker::make('expires_at')
                    ->label('Data de Expiração')
                    ->helperText('Quando o cupom expira.'),

                TextInput::make('description')
                    ->label('Descrição')
                    ->maxLength(255)
                    ->helperText('Descrição interna para administração.'),
            ]);
    }
}
