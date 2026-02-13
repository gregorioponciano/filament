<?php

namespace App\Filament\Resources\UserBans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class UserBanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('banned_by')
                    ->label('banido por')
                    ->relationship('admin', 'name')
                    ->disabled()
                    ->dehydrated()
                    ->preload()
                    ->default(fn () => Auth::id())  // 👈 preenche com o usuário logado
                    ->required(),
                DateTimePicker::make('banned_until')
                ->label('banido até'),
                Textarea::make('reason')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
