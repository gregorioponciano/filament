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
                TextInput::make('border_color')
                    ->required()
                    ->default('#000000'),
                TextInput::make('link_color')
                    ->required()
                    ->default('#2563eb'),
                TextInput::make('hover_color')
                    ->required()
                    ->default('#2563eb'),
                TextInput::make('footer_color')
                    ->required()
                    ->default('#000000'),
                TextInput::make('footer_text_color')
                    ->required()
                    ->default('#ffffff'),
                TextInput::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]);
    }
}
