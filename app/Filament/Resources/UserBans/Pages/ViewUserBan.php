<?php

namespace App\Filament\Resources\UserBans\Pages;

use App\Filament\Resources\UserBans\UserBanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserBan extends ViewRecord
{
    protected static string $resource = UserBanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
