<?php

namespace App\Filament\Resources\Enderecos\Pages;

use App\Filament\Resources\Enderecos\EnderecoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEndereco extends ViewRecord
{
    protected static string $resource = EnderecoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
