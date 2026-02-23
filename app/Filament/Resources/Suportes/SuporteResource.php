<?php

namespace App\Filament\Resources\Suportes;

use App\Filament\Resources\Suportes\Pages\CreateSuporte;
use App\Filament\Resources\Suportes\Pages\EditSuporte;
use App\Filament\Resources\Suportes\Pages\ListSuportes;
use App\Filament\Resources\Suportes\Pages\ViewSuporte;
use App\Filament\Resources\Suportes\Schemas\SuporteForm;
use App\Filament\Resources\Suportes\Schemas\SuporteInfolist;
use App\Filament\Resources\Suportes\Tables\SuportesTable;
use App\Models\Suporte;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SuporteResource extends Resource
{
    protected static ?string $model = Suporte::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static string | UnitEnum | null $navigationGroup = 'Administração';
    protected static ?string $recordTitleAttribute = 'Suporte';

    public static function form(Schema $schema): Schema
    {
        return SuporteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SuporteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuportesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSuportes::route('/'),
            'create' => CreateSuporte::route('/create'),
            'view' => ViewSuporte::route('/{record}'),
            'edit' => EditSuporte::route('/{record}/edit'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
