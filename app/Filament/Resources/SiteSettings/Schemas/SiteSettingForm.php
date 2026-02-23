<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Symfony\Component\Console\Color;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ColorPicker::make('bg_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('bg_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('primary_color')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('secondary_color')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('card_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('card_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('link_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('link_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('h1_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('h1_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('h2_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('h2_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('h3_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('h3_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('text_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('text_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('price_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('price_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('button_primary')
                    ->required()
                    ->default('#1447E6'),
                ColorPicker::make('button_secondary')
                    ->required()
                    ->default('#F0B100'),
                ColorPicker::make('input_primary')
                    ->required()
                    ->default('#ffff00'),
                ColorPicker::make('input_secondary')
                    ->required()
                    ->default('#6D28D9'),
                ColorPicker::make('hover_primary')
                    ->required()
                    ->default('#0B309A'),
                ColorPicker::make('hover_secondary')
                    ->required()
                    ->default('#C79100'),
                ColorPicker::make('border_primary')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('border_secondary')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('footer_color')
                    ->required()
                    ->default('#FFFFFF'),
                ColorPicker::make('footer_text_color')
                    ->required()
                    ->default('#000000'),
                ColorPicker::make('font_family')
                    ->required()
                    ->default('Inter'),
            ]); 
    }
}
