<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        return view('user.profile');
    }

    public function store(Request $request)
    {
        $this->validateEndereco($request);

        if (Auth::user()->enderecos()->count() >= 5) {
            return back()->with('error', 'Você atingiu o limite máximo de 5 endereços.');
        }

        Auth::user()->enderecos()->create($request->all());

        return back()->with('success', 'Endereço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);
        return view('user.profile', compact('endereco'));
    }

    public function update(Request $request, $id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);

        $this->validateEndereco($request, $id);

        $endereco->update($request->all());

        return back()->with('success', 'Endereço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $endereco = Auth::user()->enderecos()->findOrFail($id);
        $endereco->delete();

        return back()->with('error', 'Endereço removido com sucesso!');
    }

    private function validateEndereco(Request $request, $id = null)
    {
        return $request->validateWithBag('endereco', [
            'rua' => 'required|string|max:255',
            'numero' => ['required', 'string', 'max:10', Rule::unique('enderecos', 'numero')->ignore($id)],
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:100',
            'cep' => ['required', 'string', 'regex:/^\d{5}-\d{3}$/']
        ], [
            'cep.regex' => 'O CEP deve seguir o formato 00000-000.',
            'numero.unique' => 'Este número já está cadastrado.'
        ]);
    }
}