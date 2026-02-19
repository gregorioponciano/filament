<?php

namespace App\Filament\Resources\Suportes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SuporteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('assunto'),
                TextEntry::make('mensagem')
                    ->columnSpanFull(),
                TextEntry::make('resposta')
                    ->placeholder('-'),
                TextEntry::make('status'),
                IconEntry::make('lido')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
