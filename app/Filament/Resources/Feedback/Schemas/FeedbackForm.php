<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                        ->disabled()
                        ->label('Usuário')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                Select::make('produto_id')
                        ->disabled()
                        ->label('Produto')
                        ->relationship('produto', 'nome')
                        ->searchable()
                        ->preload()
                        ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }
}
