<?php

namespace App\Filament\Resources\Suportes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SuporteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('assunto')
                    ->required(),
                Textarea::make('mensagem')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('resposta'),
                TextInput::make('status')
                    ->required()
                    ->default('aberto'),
                Toggle::make('lido')
                    ->required(),
            ]);
    }
}
