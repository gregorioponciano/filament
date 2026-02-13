<?php

namespace App\Filament\Resources\UserBans\Pages;

use App\Filament\Resources\UserBans\UserBanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserBans extends ListRecords
{
    protected static string $resource = UserBanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
