<?php

namespace App\Filament\Resources\UserBans\Pages;

use App\Filament\Resources\UserBans\UserBanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserBan extends EditRecord
{
    protected static string $resource = UserBanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
