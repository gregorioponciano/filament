<?php

namespace App\Filament\Resources\Customizations\Pages;

use App\Filament\Resources\Customizations\CustomizationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomization extends CreateRecord
{
    protected static string $resource = CustomizationResource::class;
}
