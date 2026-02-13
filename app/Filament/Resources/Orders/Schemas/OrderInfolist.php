<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('endereco_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('rua')
                    ->placeholder('-'),
                TextEntry::make('numero')
                    ->placeholder('-'),
                TextEntry::make('complemento')
                    ->placeholder('-'),
                TextEntry::make('bairro')
                    ->placeholder('-'),
                TextEntry::make('cidade')
                    ->placeholder('-'),
                TextEntry::make('estado')
                    ->placeholder('-'),
                TextEntry::make('cep')
                    ->placeholder('-'),
            ]);
    }
}
