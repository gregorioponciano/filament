<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bg_color')
                    ->searchable(),
                TextColumn::make('primary_color')
                    ->searchable(),
                TextColumn::make('secondary_color')
                    ->searchable(),
                TextColumn::make('card_primary')
                    ->searchable(),
                TextColumn::make('card_secondary')
                    ->searchable(),
                TextColumn::make('link_primary')
                    ->searchable(),
                TextColumn::make('link_secondary')
                    ->searchable(),
                TextColumn::make('h1_color')
                    ->searchable(),
                TextColumn::make('h2_color')
                    ->searchable(),
                TextColumn::make('h3_color')
                    ->searchable(),
                TextColumn::make('text_primary')
                    ->searchable(),
                TextColumn::make('text_secondary')
                    ->searchable(),
                TextColumn::make('text_price')
                    ->searchable(),
                TextColumn::make('button_primary')
                    ->searchable(),
                TextColumn::make('button_secondary')
                    ->searchable(),
                TextColumn::make('input_primary')
                    ->searchable(),
                TextColumn::make('input_secondary')
                    ->searchable(),
                TextColumn::make('hover_primary')
                    ->searchable(),
                TextColumn::make('hover_secondary')
                    ->searchable(),
                TextColumn::make('border_primary')
                    ->searchable(),
                TextColumn::make('border_secondary')
                    ->searchable(),
                TextColumn::make('footer_color')
                    ->searchable(),
                TextColumn::make('footer_text_color')
                    ->searchable(),
                TextColumn::make('font_family')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
