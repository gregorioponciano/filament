<?php

namespace App\Filament\Resources\Enderecos;

use App\Filament\Resources\Enderecos\Pages\CreateEndereco;
use App\Filament\Resources\Enderecos\Pages\EditEndereco;
use App\Filament\Resources\Enderecos\Pages\ListEnderecos;
use App\Filament\Resources\Enderecos\Pages\ViewEndereco;
use App\Filament\Resources\Enderecos\Schemas\EnderecoForm;
use App\Filament\Resources\Enderecos\Schemas\EnderecoInfolist;
use App\Filament\Resources\Enderecos\Tables\EnderecosTable;
use App\Models\Endereco;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnderecoResource extends Resource
{
    protected static ?string $model = Endereco::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Endereco';

    public static function form(Schema $schema): Schema
    {
        return EnderecoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EnderecoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnderecosTable::configure($table);
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
            'index' => ListEnderecos::route('/'),
            'create' => CreateEndereco::route('/create'),
            'view' => ViewEndereco::route('/{record}'),
            'edit' => EditEndereco::route('/{record}/edit'),
        ];
    }
            public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
