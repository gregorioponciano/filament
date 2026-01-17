<?php

namespace App\Filament\Resources\Customizations\Pages;

use App\Filament\Resources\Customizations\CustomizationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomization extends EditRecord
{
    protected static string $resource = CustomizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
