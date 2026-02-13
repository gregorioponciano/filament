<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                    DateTimePicker::make('email_verified_at'),

                    Select::make('role')
                        ->options([
                            'admin' => 'Admin',
                            'user' => 'User',
                        ])
                    ->required()
                    ->default('user'),
            ]);
    }
}
