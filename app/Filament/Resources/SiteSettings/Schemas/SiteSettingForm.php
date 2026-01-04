<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;





class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 ColorPicker::make('primary_color')
                    ->required()
                    ->default('#2563eb'),
                ColorPicker::make('secondary_color')
                    ->required()
                    ->default('#6c757'),
                ColorPicker::make('text_color')
                    ->required()
                    ->default('#2563eb'),
                ColorPicker::make('bg_color')
                    ->required()
                    ->default('#ffffff'),
                ColorPicker::make('border_color')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('link_color')
                    ->required()
                    ->default('#2563eb'),
                ColorPicker::make('hover_color')
                    ->required()
                    ->default('#2563eb'),
                ColorPicker::make('footer_color')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('footer_text_color')
                    ->required()
                    ->default('#ffffff'),
                 TextInput::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]);
    }
}

