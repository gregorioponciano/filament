<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function index()
    {
        $enderecos = Auth::user()->enderecos;
        return view('enderecos.index', compact('enderecos'));
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
            'cep' => 'required|string|max:20'
        ]);

        Auth::user()->enderecos()->create($request->all());

        return redirect()->route('enderecos.index')->with('success', 'Endereço cadastrado com sucesso!');
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
            'cep' => 'required|string|max:20'
        ]);

        $endereco->update($request->all());

        return redirect()->route('enderecos.index')->with('success', 'Endereço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);
        $endereco->delete();

        return back()->with('success', 'Endereço removido com sucesso!');
    }
}