<?php

namespace App\Filament\Resources\Orders\Schemas;

use Dom\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Select::make('user_id')
                            ->label('Responsável')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())  // 👈 preenche com o usuário logado
                            ->required(),
                TextInput::make('endereco_id')
                    ->numeric(),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('pendente'),
                TextInput::make('rua'),
                TextInput::make('numero'),
                TextInput::make('complemento'),
                TextInput::make('bairro'),
                TextInput::make('cidade'),
                TextInput::make('estado'),
                TextInput::make('cep'),
            ]);
    }
}
