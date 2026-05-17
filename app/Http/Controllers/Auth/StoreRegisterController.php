<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreRegisterController extends Controller
{
public function storeRegister(Request $request)
{
    $credenciais = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'cpf' => 'nullable|string|max:14|unique:users,cpf',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|min:8',
    ]);

    $user = User::create([
        'name' => $credenciais['name'],
        'email' => $credenciais['email'],
        'cpf' => $credenciais['cpf'] ?? null,
        'phone' => $credenciais['phone'] ?? null,
        'password' => Hash::make($credenciais['password']),
        'role' => 'user',
    ]);

    Auth::login($user);

    $request->session()->regenerate();

    return redirect('/login')->with('sucesso', 'Cadastro realizado com sucesso!' );
}

}
