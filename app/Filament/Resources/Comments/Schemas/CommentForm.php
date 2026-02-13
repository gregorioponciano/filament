<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->disabled()
                    ->required()
                    ->numeric(),
                TextInput::make('commentable_type')
                    ->disabled()
                    ->required(),
                TextInput::make('commentable_id')
                    ->disabled()
                    ->required()
                    ->numeric(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('fingerprint'),
            ]);
    }
}
