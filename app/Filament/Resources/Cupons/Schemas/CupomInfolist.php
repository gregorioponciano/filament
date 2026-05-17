<?php

namespace App\Filament\Resources\Cupons\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CupomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalhes do Cupom')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('code')->label('Código')->badge()->color('primary'),
                        TextEntry::make('type')->label('Tipo')->badge()
                            ->color(fn ($state) => $state === 'percentage' ? 'success' : 'warning')
                            ->formatStateUsing(fn ($state) => $state === 'percentage' ? 'Percentual' : 'Valor Fixo'),
                        TextEntry::make('value')->label('Valor')
                            ->money('BRL')
                            ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? "{$state}%" : "R$ " . number_format($state, 2, ',', '.')),
                        TextEntry::make('min_value')->label('Valor Mínimo')->money('BRL')->default('—'),
                        TextEntry::make('max_uses')->label('Usos Máximos')->default('Ilimitado'),
                        TextEntry::make('used_count')->label('Usos Atuais'),
                        TextEntry::make('product.nome')->label('Produto')->default('—'),
                        TextEntry::make('starts_at')->label('Início')->date()->default('—'),
                        TextEntry::make('expires_at')->label('Expira em')->date()->default('—'),
                        TextEntry::make('active')->label('Ativo')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state) => $state ? 'Sim' : 'Não'),
                    ]),
            ]);
    }
}
