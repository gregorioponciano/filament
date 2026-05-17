<?php

namespace App\Filament\Resources\Cupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CuponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn ($state) => $state === 'percentage' ? 'success' : 'warning')
                    ->formatStateUsing(fn ($state) => $state === 'percentage' ? '%' : 'R$'),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? "{$state}%" : "R$ " . number_format($state, 2, ',', '.'))
                    ->sortable(),
                TextColumn::make('used_count')
                    ->label('Usos')
                    ->sortable(),
                TextColumn::make('max_uses')
                    ->label('Limite')
                    ->default('∞'),
                TextColumn::make('expires_at')
                    ->label('Expira')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->label('Ativo')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
