<?php

namespace App\Filament\Resources\Cupons;

use App\Filament\Resources\Cupons\Pages\CreateCupom;
use App\Filament\Resources\Cupons\Pages\EditCupom;
use App\Filament\Resources\Cupons\Pages\ListCupons;
use App\Filament\Resources\Cupons\Pages\ViewCupom;
use App\Filament\Resources\Cupons\Schemas\CupomForm;
use App\Filament\Resources\Cupons\Schemas\CupomInfolist;
use App\Filament\Resources\Cupons\Tables\CuponsTable;
use App\Models\Cupom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CupomResource extends Resource
{
    protected static ?string $model = Cupom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Gift;
    protected static string | UnitEnum | null $navigationGroup = 'Shop';
    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return CupomForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CupomInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CuponsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCupons::route('/'),
            'create' => CreateCupom::route('/create'),
            'view' => ViewCupom::route('/{record}'),
            'edit' => EditCupom::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('active', true)->count();
    }
}
