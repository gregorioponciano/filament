<?php

namespace App\Filament\Resources\Suportes\Pages;

use App\Filament\Resources\Suportes\SuporteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSuporte extends EditRecord
{
    protected static string $resource = SuporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
