<?php

namespace App\Filament\Resources\Enderecos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\{
    TextInput,
    Select
};

class EnderecoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make('Vínculo')
                ->schema([
                    Select::make('user_id')
                        ->disabled()
                        ->label('Usuário')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            Section::make('Endereço')
                ->schema([
                    Grid::make(3)->schema([

                        TextInput::make('cep')
                            ->label('CEP')
                            ->required()
                            ->mask('99999-999')
                            ->live(onBlur: true)
                            ->helperText('Digite o CEP para buscar o endereço'),

                        TextInput::make('estado')
                            ->label('Estado')
                            ->required()
                            ->maxLength(2),

                        TextInput::make('cidade')
                            ->label('Cidade')
                            ->required(),

                        TextInput::make('bairro')
                            ->label('Bairro')
                            ->required(),

                        TextInput::make('rua')
                            ->label('Rua')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('numero')
                            ->label('Número')
                            ->required(),

                        TextInput::make('complemento')
                            ->label('Complemento')
                            ->columnSpanFull(),

                    ]),
                ]),
        ]);
    }
}

