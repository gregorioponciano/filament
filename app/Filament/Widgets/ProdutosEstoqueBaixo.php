<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use App\Filament\Resources\Produtos\ProdutoResource;
use Filament\Actions\Action as ActionsAction;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProdutosEstoqueBaixo extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Estoque Crítico';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produto::query()
                    ->with('categoria')
                    ->where('estoque', '<=', 5)
                    ->orderBy('estoque')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('nome')
                    ->label('Produto')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn (Produto $record) => $record->categoria?->nome ?? 'Sem categoria'),

                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estoque')
                    ->label('Estoque')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state == 0 ? 'danger' : 'warning')
                    ->formatStateUsing(fn ($state) => $state == 0 ? 'Esgotado' : "{$state} un."),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado')
                    ->since(),
            ])
            ->actions([
                ActionsAction::make('repor')
                    ->label('Repor')
                    ->icon('heroicon-o-plus')
                    ->color('warning')
                    ->url(fn (Produto $record) =>
                        ProdutoResource::getUrl('edit', ['record' => $record])
                    ),
            ])
            ->emptyStateHeading('Estoque saudável')
            ->emptyStateDescription('Nenhum produto crítico no momento.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}
