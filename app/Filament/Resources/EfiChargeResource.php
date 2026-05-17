<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EfiChargeResource\Pages;
use App\Models\EfiCharge;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class EfiChargeResource extends Resource
{
    protected static ?string $model = EfiCharge::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static string | UnitEnum | null $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Cobranças (Boleto/Cartão)';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informações da Cobrança')
                    ->schema([
                        Forms\Components\TextInput::make('charge_id')
                            ->label('ID Cobrança')
                            ->disabled(),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Método')
                            ->disabled(),
                        Forms\Components\TextInput::make('status')
                            ->disabled(),
                        Forms\Components\TextInput::make('total')
                            ->disabled()
                            ->prefix('R$'),
                        Forms\Components\TextInput::make('card_mask')
                            ->label('Cartão')
                            ->disabled(),
                        Forms\Components\TextInput::make('installments')
                            ->label('Parcelas')
                            ->disabled(),
                        Forms\Components\TextInput::make('refusal_reason')
                            ->label('Motivo Recusa')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Pago em')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('Boleto')
                    ->schema([
                        Forms\Components\TextInput::make('boleto_url')
                            ->label('URL do Boleto')
                            ->disabled(),
                        Forms\Components\TextInput::make('boleto_barcode')
                            ->label('Código de Barras')
                            ->disabled(),
                        Forms\Components\TextInput::make('boleto_expire_at')
                            ->label('Vencimento')
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
                Forms\Components\Section::make('Dados da Resposta')
                    ->schema([
                        Forms\Components\KeyValue::make('payload_response')
                            ->disabled(),
                        Forms\Components\KeyValue::make('notification_data')
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
                TextColumn::make('charge_id')
                    ->label('ID Efí')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->label('Método')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boleto' => 'info',
                        'credit_card' => 'warning',
                        default => 'secondary',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'boleto' => 'heroicon-o-document-text',
                        'credit_card' => 'heroicon-o-credit-card',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'boleto' => 'Boleto',
                        'credit_card' => 'Cartão',
                        default => $state,
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new', 'waiting' => 'gray',
                        'paid', 'approved', 'completed' => 'success',
                        'unpaid', 'refunded', 'canceled' => 'danger',
                        default => 'warning',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'new', 'waiting' => 'heroicon-o-clock',
                        'paid', 'approved', 'completed' => 'heroicon-o-check-circle',
                        'unpaid', 'refunded', 'canceled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),
                TextColumn::make('total')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('paid_at')
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
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Método')
                    ->options([
                        'boleto' => 'Boleto',
                        'credit_card' => 'Cartão',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Novo',
                        'waiting' => 'Aguardando',
                        'paid' => 'Pago',
                        'approved' => 'Aprovado',
                        'completed' => 'Completo',
                        'unpaid' => 'Não Pago',
                        'canceled' => 'Cancelado',
                        'refunded' => 'Reembolsado',
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
            'index' => Pages\ListEfiCharges::route('/'),
            'view' => Pages\ViewEfiCharge::route('/{record}'),
        ];
    }
}
