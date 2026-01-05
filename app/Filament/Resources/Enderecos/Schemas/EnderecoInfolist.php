<?php

namespace App\Filament\Resources\Enderecos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EnderecoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('rua'),
                TextEntry::make('numero'),
                TextEntry::make('complemento')
                    ->placeholder('-'),
                TextEntry::make('bairro'),
                TextEntry::make('cidade'),
                TextEntry::make('estado'),
                TextEntry::make('cep'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
