<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Models\Notification;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bell';

    protected static string | UnitEnum | null $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Notificações';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informações da Notificação')
                    ->schema([
                        Forms\Components\TextInput::make('type')
                            ->label('Tipo')
                            ->disabled(),
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->label('Mensagem')
                            ->disabled(),
                        Forms\Components\TextInput::make('icon')
                            ->disabled(),
                        Forms\Components\TextInput::make('color')
                            ->disabled(),
                        Forms\Components\TextInput::make('action_url')
                            ->label('URL de Ação')
                            ->disabled(),
                        Forms\Components\Toggle::make('read')
                            ->label('Lida')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('Relacionamentos')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
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
                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'order_created' => 'info',
                        'payment_confirmed' => 'success',
                        'support_reply' => 'warning',
                        'system' => 'gray',
                        default => 'secondary',
                    }),
                TextColumn::make('title')
                    ->label('Título')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Mensagem')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('read')
                    ->label('Lida')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Sim' : 'Não'),
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('read')
                    ->label('Lida')
                    ->options([
                        '0' => 'Não lida',
                        '1' => 'Lida',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'order_created' => 'Pedido Criado',
                        'payment_confirmed' => 'Pagamento Confirmado',
                        'support_reply' => 'Resposta Suporte',
                        'system' => 'Sistema',
                    ]),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
            'view' => Pages\ViewNotification::route('/{record}'),
        ];
    }
}
