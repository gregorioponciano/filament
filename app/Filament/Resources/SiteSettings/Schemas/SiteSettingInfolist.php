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
                TextEntry::make('primary_color'),
                TextEntry::make('secondary_color'),
                TextEntry::make('text_color'),
                TextEntry::make('bg_color'),
                TextEntry::make('border_color'),
                TextEntry::make('link_color'),
                TextEntry::make('hover_color'),
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
