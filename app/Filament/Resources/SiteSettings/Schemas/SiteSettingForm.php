<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ColorPicker::make('bg_color')
                    ->required()
                    ->default('#F5F3FF'),
                ColorPicker::make('primary_color')
                    ->required()
                    ->default('#FACC15'),
                ColorPicker::make('secondary_color')
                    ->required()
                    ->default('#44474c'),
                ColorPicker::make('card_primary')
                    ->required()
                    ->default('#212121'),
                ColorPicker::make('card_secondary')
                    ->required()
                    ->default('#C4B5FD'),
                ColorPicker::make('link_primary')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('link_secondary')
                    ->required()
                    ->default('#9333EA'),
                ColorPicker::make('h1_color')
                    ->required()
                    ->default('#111827'),
                ColorPicker::make('h2_color')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('h3_color')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('text_primary')
                    ->required()
                    ->default('#ffffff'),
                ColorPicker::make('text_secondary')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('text_price')
                    ->required()
                    ->default('#0ff000'),
                ColorPicker::make('button_primary')
                    ->required()
                    ->default('#FACC15'),
                ColorPicker::make('button_secondary')
                    ->required()
                    ->default('#0ff000'),
                ColorPicker::make('input_primary')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('input_secondary')
                    ->required()
                    ->default('#6D28D9'),
                ColorPicker::make('hover_primary')
                    ->required()
                    ->default('#EAB308'),
                ColorPicker::make('hover_secondary')
                    ->required()
                    ->default('#0faa00'),
                ColorPicker::make('border_primary')
                    ->required()
                    ->default('#E5E7EB'),
                ColorPicker::make('border_secondary')
                    ->required()
                    ->default('#C4B5FD'),
                ColorPicker::make('footer_color')
                    ->required()
                    ->default('#2E1065'),
                ColorPicker::make('footer_text_color')
                    ->required()
                    ->default('#EDE9FE'),
                ColorPicker::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]);
    }
}
