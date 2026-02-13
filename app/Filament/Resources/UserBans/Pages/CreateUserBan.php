<?php

namespace App\Filament\Resources\UserBans\Pages;

use App\Filament\Resources\UserBans\UserBanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserBan extends CreateRecord
{
    protected static string $resource = UserBanResource::class;
}
