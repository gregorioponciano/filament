<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Customization;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use PhpParser\Node\Expr\FuncCall;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Otimização: Agrupa o compartilhamento de dados globais (Menu, Configurações).

        View::composer('*', function ($view) {
            $view->with('siteSetting', SiteSetting::first());
            $view->with('categorias', Categoria::where('ativo', true)->get());
            $view->with('enderecos', Endereco::all());
            $view->with('customizations', Customization::latest()->first());
        });

        // Correção: Injeta produtos apenas no dashboard do usuário.
        // Isso resolve o erro da página user.dashboard sem quebrar a listagem de categorias.
        View::composer('user.dashboard', function ($view) {
            $view->with('produtos', Produto::where('ativo', true)->paginate(9));
        });
    }
}
