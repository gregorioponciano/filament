<?php

namespace App\Filament\Resources\Produtos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProdutoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                Textarea::make('descricao')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('preco')
                    ->required()
                    ->numeric(),
                TextInput::make('imagem')
                    ->required(),
                TextInput::make('estoque')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('categoria_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
