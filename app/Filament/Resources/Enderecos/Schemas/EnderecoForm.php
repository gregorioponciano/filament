<?php

namespace App\Filament\Resources\Enderecos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnderecoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('rua')
                    ->required(),
                TextInput::make('numero')
                    ->required(),
                TextInput::make('complemento'),
                TextInput::make('bairro')
                    ->required(),
                TextInput::make('cidade')
                    ->required(),
                TextInput::make('estado')
                    ->required(),
                TextInput::make('cep')
                    ->required(),
            ]);
    }
}
