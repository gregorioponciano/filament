<?php

namespace App\Filament\Resources\UserBans;

use App\Filament\Resources\UserBans\Pages\CreateUserBan;
use App\Filament\Resources\UserBans\Pages\EditUserBan;
use App\Filament\Resources\UserBans\Pages\ListUserBans;
use App\Filament\Resources\UserBans\Pages\ViewUserBan;
use App\Filament\Resources\UserBans\Schemas\UserBanForm;
use App\Filament\Resources\UserBans\Schemas\UserBanInfolist;
use App\Filament\Resources\UserBans\Tables\UserBansTable;
use App\Models\UserBan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserBanResource extends Resource
{
    protected static ?string $model = UserBan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::NoSymbol;

    protected static ?string $recordTitleAttribute = 'UserBan';

    public static function form(Schema $schema): Schema
    {
        return UserBanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserBanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserBansTable::configure($table);
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
            'index' => ListUserBans::route('/'),
            'create' => CreateUserBan::route('/create'),
            'view' => ViewUserBan::route('/{record}'),
            'edit' => EditUserBan::route('/{record}/edit'),
        ];
    }
        public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
