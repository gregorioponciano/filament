<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ShowLoginController;
use App\Http\Controllers\Auth\ShowRegisterController;
use App\Http\Controllers\Auth\StoreLoginController;
use App\Http\Controllers\Auth\StoreRegisterController;

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [ShowLoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [StoreLoginController::class, 'storeLogin'])->name('store.login');
Route::get('/register', [ShowRegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [StoreRegisterController::class, 'storeRegister'])->name('store.register');
Route::post('/logout', [LogoutController::class, 'storeLogout'])->name('store.logout');

Route::get('/user', [DashboardController::class, 'dashboard'])->name('user.dashboard');