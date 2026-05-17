<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CouponInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code')
                    ->label('Código')
                    ->badge()
                    ->color('primary')
                    ->copyable(),

                TextEntry::make('tipo_desconto')
                    ->label('Tipo'),

                TextEntry::make('valor_formatado')
                    ->label('Valor do Desconto'),

                TextEntry::make('min_order_value')
                    ->label('Valor Mínimo')
                    ->money('BRL')
                    ->placeholder('Sem mínimo'),

                TextEntry::make('max_uses')
                    ->label('Limite Total')
                    ->placeholder('Ilimitado'),

                TextEntry::make('used_count')
                    ->label('Usos Atuais'),

                TextEntry::make('max_uses_per_user')
                    ->label('Limite por Usuário')
                    ->placeholder('Ilimitado'),

                TextEntry::make('active')
                    ->label('Ativo')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),

                TextEntry::make('starts_at')
                    ->label('Data de Início')
                    ->dateTime()
                    ->placeholder('Imediato'),

                TextEntry::make('expires_at')
                    ->label('Data de Expiração')
                    ->dateTime()
                    ->placeholder('Sem expiração'),

                TextEntry::make('description')
                    ->label('Descrição')
                    ->placeholder('-'),

                TextEntry::make('creator.name')
                    ->label('Criado por')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime(),
            ]);
    }
}
