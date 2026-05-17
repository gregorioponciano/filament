<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PixTransactionResource\Pages;
use App\Models\PixTransaction;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;

class PixTransactionResource extends Resource
{
    protected static ?string $model = PixTransaction::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';

    protected static string | UnitEnum | null $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Transações PIX';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informações da Transação')
                    ->schema([
                        Forms\Components\TextInput::make('txid')
                            ->label('TXID')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->disabled(),
                        Forms\Components\TextInput::make('valor')
                            ->disabled()
                            ->prefix('R$'),
                        Forms\Components\DateTimePicker::make('pago_em')
                            ->disabled(),
                        Forms\Components\TextInput::make('end_to_end_id')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('Relacionamentos')
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'id')
                            ->disabled(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('QR Code')
                    ->schema([
                        Forms\Components\Textarea::make('qrcode_base64')
                            ->disabled(),
                        Forms\Components\TextInput::make('pix_copia_cola')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('Webhook')
                    ->schema([
                        Forms\Components\KeyValue::make('webhook_received')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('order_id')
                    ->label('Pedido')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('txid')
                    ->label('TXID')
                    ->limit(12)
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ATIVA' => 'warning',
                        'CONCLUIDA' => 'success',
                        'REMOVIDA_PELO_PSP' => 'danger',
                        default => 'secondary',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'ATIVA' => 'heroicon-o-clock',
                        'CONCLUIDA' => 'heroicon-o-check-circle',
                        'REMOVIDA_PELO_PSP' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),
                TextColumn::make('valor')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('pago_em')
                    ->label('Pago em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'ATIVA' => 'Ativa',
                        'CONCLUIDA' => 'Concluída',
                        'REMOVIDA_PELO_PSP' => 'Expirada',
                    ]),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPixTransactions::route('/'),
            'view' => Pages\ViewPixTransaction::route('/{record}'),
        ];
    }
}
