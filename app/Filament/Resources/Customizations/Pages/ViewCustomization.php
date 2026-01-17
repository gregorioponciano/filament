<?php

namespace App\Filament\Resources\Customizations\Pages;

use App\Filament\Resources\Customizations\CustomizationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomization extends ViewRecord
{
    protected static string $resource = CustomizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
