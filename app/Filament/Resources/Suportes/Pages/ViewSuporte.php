<?php

namespace App\Filament\Resources\Suportes\Pages;

use App\Filament\Resources\Suportes\SuporteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSuporte extends ViewRecord
{
    protected static string $resource = SuporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
