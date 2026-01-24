<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiteSettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('bg_color'),
                TextEntry::make('primary_color'),
                TextEntry::make('secondary_color'),
                TextEntry::make('card_primary'),
                TextEntry::make('card_secondary'),
                TextEntry::make('link_primary'),
                TextEntry::make('link_secondary'),
                TextEntry::make('h1_color'),
                TextEntry::make('h2_color'),
                TextEntry::make('h3_color'),
                TextEntry::make('text_primary'),
                TextEntry::make('text_secondary'),
                TextEntry::make('text_price'),
                TextEntry::make('button_primary'),
                TextEntry::make('button_secondary'),
                TextEntry::make('input_primary'),
                TextEntry::make('input_secondary'),
                TextEntry::make('hover_primary'),
                TextEntry::make('hover_secondary'),
                TextEntry::make('border_primary'),
                TextEntry::make('border_secondary'),
                TextEntry::make('footer_color'),
                TextEntry::make('footer_text_color'),
                TextEntry::make('font_family'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
