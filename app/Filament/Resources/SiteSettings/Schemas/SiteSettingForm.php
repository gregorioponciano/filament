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
                TextInput::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]);
    }
}
