<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enderecos = $user->enderecos;
        return view('user.profile', compact('user', 'enderecos'));
    }

    public function create()
    {
        return view('enderecos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:100',
            'cep' => ['required', 'string', 'regex:/^\d{5}-\d{3}$/']
        ], [
            'cep.regex' => 'O CEP deve seguir o formato XXXXX-XXX.'
        ]);

        if (Auth::user()->enderecos()->count() >= 5) {
            return back()->with('error', 'Você atingiu o limite máximo de 5 endereços.');
        }

        Auth::user()->enderecos()->create($request->all());

        return back()->with('success', 'Endereço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);
        return view('enderecos.edit', compact('endereco'));
    }

    public function update(Request $request, $id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);

        $request->validate([
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:100',
            'cep' => ['required', 'string', 'regex:/^\d{5}-\d{3}$/']
        ], [
            'cep.regex' => 'O CEP deve seguir o formato XXXXX-XXX.'
        ]);

        $endereco->update($request->all());

        return back()->with('success', 'Endereço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);
        $endereco->delete();

        return back()->with('error', 'Endereço removido com sucesso!');
    }
}