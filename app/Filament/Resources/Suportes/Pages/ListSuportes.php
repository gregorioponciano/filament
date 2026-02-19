<?php

namespace App\Filament\Resources\Suportes\Pages;

use App\Filament\Resources\Suportes\SuporteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuportes extends ListRecords
{
    protected static string $resource = SuporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
