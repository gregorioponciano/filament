<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ShowLoginController;
use App\Http\Controllers\Auth\ShowRegisterController;
use App\Http\Controllers\Auth\StoreLoginController;
use App\Http\Controllers\Auth\StoreRegisterController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentVoteController;
use App\Http\Controllers\DetalhesController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentViewController;
use App\Http\Controllers\PixController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Suporte\ShowSuportController;
use App\Http\Controllers\Suporte\StoreSuportController;
use App\Http\Controllers\User\DestroyProfileController;
use App\Http\Controllers\User\EnderecoController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ShowProfileController;
use App\Http\Controllers\User\StoreProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WebhookCobrancasController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }
            return redirect('/user');
        }
        return view('auth.login');
    })->name('home');

Route::get('/login', [ShowLoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [StoreLoginController::class, 'storeLogin'])->name('store.login');
Route::get('/register', [ShowRegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [StoreRegisterController::class, 'storeRegister'])->name('store.register');
Route::post('/logout', [LogoutController::class, 'storeLogout'])->name('store.logout');

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

Route::post('/pedido', [OrderController::class, 'store'])->name('pedido.store')->middleware([Authenticate::class]);
Route::get('/pedido/{order}', [OrderController::class, 'show'])->name('produtos.orders')->middleware([Authenticate::class]);
Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index')->middleware([Authenticate::class]);
Route::put('/pedido/cancelar/{order}', [OrderController::class, 'cancelar'])->name('orders.cancelar')->middleware([Authenticate::class]);

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware([Authenticate::class]);
Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update')->middleware([Authenticate::class]);
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware([Authenticate::class]);
Route::post('/comments/{comment}/vote', [CommentVoteController::class, 'vote'])->name('comments.vote')->middleware([Authenticate::class]);

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle')->middleware([Authenticate::class]);
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index')->middleware([Authenticate::class]);

Route::get('/produto/{id}/avaliar', [FeedbackController::class, 'create'])->name('feedback.create')->middleware([Authenticate::class]);
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store')->middleware([Authenticate::class]);

Route::get('/suporte', [ShowSuportController::class, 'showSuporte'])->name('show.suporte')->middleware([Authenticate::class]);
Route::post('/suporte', [StoreSuportController::class, 'storeSuporte'])->name('store.suporte')->middleware([Authenticate::class]);
Route::get('/suporte/chamados', [ShowSuportController::class, 'showChamados'])->name('suporte.chamados')->middleware([Authenticate::class]);
Route::get('/suporte/chamados/{suporte}', [ShowSuportController::class, 'showChamadoDetalhes'])->name('suporte.detalhes')->middleware([Authenticate::class]);

// PIX Routes
Route::prefix('pix')->middleware([Authenticate::class])->group(function () {
    Route::post('/checkout', [PixController::class, 'checkout'])->name('pix.checkout');
    Route::get('/{pixTransaction}', [PixController::class, 'show'])->name('pix.show');
    Route::get('/{pixTransaction}/status', [PixController::class, 'status'])->name('pix.status');
    Route::get('/sucesso/{order}', [PixController::class, 'sucesso'])->name('pix.sucesso');
});

// Unified Checkout (3 métodos)
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout.process')->middleware([Authenticate::class]);

// Payment Result Views
Route::middleware([Authenticate::class])->group(function () {
    Route::get('/pagamento/boleto/{order}', [PaymentViewController::class, 'boletoShow'])->name('payment.boleto.show');
    Route::get('/pagamento/cartao/sucesso/{order}', [PaymentViewController::class, 'cardSuccess'])->name('payment.card.success');
    Route::get('/pagamento/cartao/recusado/{order}', [PaymentViewController::class, 'cardFailed'])->name('payment.card.failed');
});

// Notifications
Route::prefix('notificacoes')->middleware([Authenticate::class])->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::get('/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});

// Webhook (sem CSRF, sem auth - external)
Route::post('/webhook/pix', [WebhookController::class, 'handle'])->name('webhook.pix')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/webhook/cobrancas', [WebhookCobrancasController::class, 'handle'])->name('webhook.cobrancas')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Cupons
Route::prefix('cupom')->middleware([Authenticate::class])->group(function () {
    Route::post('/aplicar', [\App\Http\Controllers\CupomController::class, 'apply'])->name('cupom.apply');
    Route::post('/remover', [\App\Http\Controllers\CupomController::class, 'remove'])->name('cupom.remove');
});
