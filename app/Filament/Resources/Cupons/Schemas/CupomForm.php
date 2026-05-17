<?php

namespace App\Filament\Resources\Cupons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CupomForm
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
                    ->uppercase(),
                Select::make('type')
                    ->label('Tipo de Desconto')
                    ->options([
                        'fixed' => 'Valor Fixo (R$)',
                        'percentage' => 'Percentual (%)',
                    ])
                    ->required()
                    ->default('fixed'),
                TextInput::make('value')
                    ->label('Valor do Desconto')
                    ->required()
                    ->numeric()
                    ->minValue(0.01),
                TextInput::make('min_value')
                    ->label('Valor Mínimo do Pedido (R$)')
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Opcional'),
                TextInput::make('max_uses')
                    ->label('Usos Máximos')
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Ilimitado se vazio'),
                TextInput::make('used_count')
                    ->label('Usos Atuais')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->visible(fn ($record) => $record !== null),
                Select::make('product_id')
                    ->label('Produto Específico (opcional)')
                    ->relationship('product', 'nome')
                    ->searchable()
                    ->preload()
                    ->placeholder('Aplicar a todos os produtos'),
                DatePicker::make('starts_at')
                    ->label('Início da Validade')
                    ->placeholder('Opcional'),
                DatePicker::make('expires_at')
                    ->label('Data de Expiração')
                    ->placeholder('Opcional'),
                Toggle::make('active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }
}
