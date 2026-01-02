<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('primary_color')
                    ->required()
                    ->default('#2563eb'),
                TextInput::make('secondary_color')
                    ->required()
                    ->default('#6c757'),
                TextInput::make('text_color')
                    ->required()
                    ->default('#2563eb'),
                TextInput::make('bg_color')
                    ->required()
                    ->default('#ffffff'),
                TextInput::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]);
    }
}
