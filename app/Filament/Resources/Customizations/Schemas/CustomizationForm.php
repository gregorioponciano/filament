<?php

namespace App\Filament\Resources\Customizations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                FileUpload::make('imagem')
                ->image()
                ->imageEditor()
                    ->disk('public')
                    ->directory('images/customizations')
                    ->visibility('public')
                    ->required()
                    ->helperText('PNG ou JPG até 2MB'),
            ]);
    }
}
