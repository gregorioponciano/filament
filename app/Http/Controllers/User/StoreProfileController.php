<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Adicione esta linha

class StoreProfileController extends Controller
{
    // ⚠️ VERIFIQUE AQUI QUAL É A ASSINATURA DO MÉTODO ⚠️
    
    // ERRADO - Se tiver 2 parâmetros:
    // public function storeProfile(Request $request, $id) { ... }
    
    // CORRETO - Apenas 1 parâmetro:
    public function storeProfile(Request $request)
    {
        $user = Auth::user(); // Ou $request->user()
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id), // Corrigido
            ],
            // outros campos...
        ]);
        
        $user->update($validated);
        
        return redirect()->back()->with('success', 'Perfil atualizado!');
    }
}
