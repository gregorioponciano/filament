<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreLoginController extends Controller
{
    public function storeLogin(Request $request) 
    {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/user')->with('sucesso', 'Login realizado com sucesso!');
        } 
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        
    }
}
