<?php

namespace App\Filament\Resources\Customizations\Pages;

use App\Filament\Resources\Customizations\CustomizationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomizations extends ListRecords
{
    protected static string $resource = CustomizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
