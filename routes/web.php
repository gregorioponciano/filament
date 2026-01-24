<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ShowLoginController;
use App\Http\Controllers\Auth\ShowRegisterController;
use App\Http\Controllers\Auth\StoreLoginController;
use App\Http\Controllers\Auth\StoreRegisterController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DetalhesController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\DestroyProfileController;
use App\Http\Controllers\User\EnderecoController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ShowProfileController;
use App\Http\Controllers\User\StoreProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;



Route::get('/login', [ShowLoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [StoreLoginController::class, 'storeLogin'])->name('store.login');
Route::get('/register', [ShowRegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [StoreRegisterController::class, 'storeRegister'])->name('store.register');
Route::post('/logout', [LogoutController::class, 'storeLogout'])->name('store.logout');



    // Rotas gerais para usuários autenticados
   
Route::get('/user', [UserDashboardController::class, 'dashboard'])->name('user.dashboard')->middleware([Authenticate::class]);
Route::get('/user/profile', [ShowProfileController::class, 'showProfile'])->name('show.profile')->middleware([Authenticate::class]);
Route::put('/user/profile', [StoreProfileController::class, 'storeProfile'])->name('store.profile')->middleware([Authenticate::class]);
Route::delete('/user/profile/{id}', [DestroyProfileController::class, 'destroyProfile'])->name('destroy.profile')->middleware([Authenticate::class]);
Route::resource('/user/enderecos', EnderecoController::class)->names('enderecos')->middleware([Authenticate::class]);

Route::get('/produtos', [ProdutoController::class, 'showProdutos'])->name('show.produtos')->middleware([Authenticate::class, AdminMiddleware::class]);
Route::get('/produto/{slug}', [DetalhesController::class, 'showDetalhes'])->name('show.detalhes')->middleware([Authenticate::class]);
Route::get('/categorias/{slug}', [CategoriaController::class, 'showCategorias'])->name('show.categorias')->middleware([Authenticate::class]);
Route::get('/search', [SearchController::class, 'search'])->name('search')->middleware([Authenticate::class]);

Route::get('/carrinho', [CarrinhoController::class, 'showCarrinho'])->name('show.carrinho')->middleware([Authenticate::class]);
Route::post('/addcarrinho', [CarrinhoController::class, 'add'])->name('site.addcarrinho')->middleware([Authenticate::class]);
Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover'); 
Route::delete('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar'); 
Route::put('/carrinho/atualizar', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar'); 


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware([Authenticate::class]);
// Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware([Authenticate::class]);
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle')->middleware([Authenticate::class]);
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index')->middleware([Authenticate::class]);

    // Rotas para administradores
