<?php

namespace App\Providers;

use App\Models\Categoria;
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
        View::composer('*', function ($view) {
            $view->with('siteSetting', SiteSetting::first());
        });
                // Compartilha a variável $categoriasMenu com TODAS as views
        View::composer('*', function ($view) {
            $view->with('categorias', Categoria::all());
        });
                View::composer('*', function ($view) {
            $view->with('produtos', Produto::paginate(9));
        });


    }
}
