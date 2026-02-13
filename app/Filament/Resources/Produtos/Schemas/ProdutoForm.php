<?php

namespace App\Filament\Resources\Produtos\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\{
    TextInput,
    Textarea,
    Toggle,
    Select,
    FileUpload
};
use Illuminate\Support\Facades\Auth;

class ProdutoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Section::make('Produto')
                ->schema([
                    Grid::make(2)->schema([

                        TextInput::make('nome')
                            ->label('Nome do produto')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug exemplo(www.seusite.com/slug)')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Gerado automaticamente')                                   
                            ->dehydrated(),

                        Textarea::make('descricao')
                            ->label('Descrição')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),

                    ]),
                ]),

            Section::make('Preço e Estoque')
                ->schema([
                    Grid::make(3)->schema([

                        TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->prefix('R$')
                            ->required(),

                        TextInput::make('estoque')
                            ->label('Estoque')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),

                    ]),
                ]),

            Section::make('Relacionamentos')
                ->schema([
                    Grid::make(2)->schema([

                        Select::make('categoria_id')
                            ->label('Categoria')
                            ->relationship('categoria', 'nome')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('user_id')
                            ->label('Responsável')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())  // 👈 preenche com o usuário logado
                            ->required(),
                    ]),
                ]),

            Section::make('Imagem')
                ->schema([
                    FileUpload::make('imagem')
                        ->label('Imagem do produto')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('images/produtos')
                        ->visibility('public')
                        ->required()
                        ->helperText('PNG ou JPG até 2MB'),
                ]),
                                Toggle::make('ativo')
                    ->required()
                    ->default(true),
        ]);
    }
}
