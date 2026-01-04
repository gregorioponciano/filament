<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Endereco;
use App\Models\Produto;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
            $view->with('categorias', Categoria::all());
          
        });

        // Correção: Injeta produtos apenas no dashboard do usuário.
        // Isso resolve o erro da página user.dashboard sem quebrar a listagem de categorias.
        View::composer('user.dashboard', function ($view) {
            $view->with('produtos', Produto::paginate(9));
        });

        view::composer('*', function ($view) {
            $view->with('enderecos', Endereco::all());
        });
    }
}
