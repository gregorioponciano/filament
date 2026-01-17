<?php

namespace App\Filament\Resources\Customizations;

use App\Filament\Resources\Customizations\Pages\CreateCustomization;
use App\Filament\Resources\Customizations\Pages\EditCustomization;
use App\Filament\Resources\Customizations\Pages\ListCustomizations;
use App\Filament\Resources\Customizations\Pages\ViewCustomization;
use App\Filament\Resources\Customizations\Schemas\CustomizationForm;
use App\Filament\Resources\Customizations\Schemas\CustomizationInfolist;
use App\Filament\Resources\Customizations\Tables\CustomizationsTable;
use App\Models\Customization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomizationResource extends Resource
{
    protected static ?string $model = Customization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Customization';

    public static function form(Schema $schema): Schema
    {
        return CustomizationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomizationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomizationsTable::configure($table);
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
            'index' => ListCustomizations::route('/'),
            'create' => CreateCustomization::route('/create'),
            'view' => ViewCustomization::route('/{record}'),
            'edit' => EditCustomization::route('/{record}/edit'),
        ];
    }
                public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
