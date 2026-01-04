@extends('user.dashboard')

@section('title', 'Perfil')

@section('dashboard')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Mensagem de sucesso --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Mensagem de erro (Limite ou Validação) --}}
    @if (session('error'))
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
            Verifique os campos do formulário de endereço.
        </div>
    @endif

    {{-- PERFIL --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 mb-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Meu Perfil
        </h1>

        <form
            action="{{ route('store.profile', ['id' => $user->id]) }}"
            method="POST"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input
                    type="text"
                    name="name"
                    value="{{ $user->name }}"
                    required
                    class="input"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ $user->email }}"
                    required
                    class="input"
                >
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-between pt-4">
                <button
                    type="submit"
                    class="btn-primary bg-blue-600 text-white hover:bg-blue-700 transition p-2.5 rounded-lg w-full sm:w-auto "
                >
                    Atualizar Perfil
                </button>

                <button
                    type="button"
                    onclick="confirmarExclusaoConta()"
                    class="btn-danger"
                >
                    Excluir Conta
                </button>
            </div>
        </form>

        {{-- FORM DELETE CONTA --}}
        <form
            id="form-delete-conta"
            action="{{ route('destroy.profile', ['id' => $user->id]) }}"
            method="POST"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>
    </div>

    {{-- ENDEREÇOS --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Meus Endereços
        </h2>
        
        <div class="mb-4 flex justify-between items-center">
            <span class="text-sm text-gray-500">
                {{ $user->enderecos->count() }} / 5 endereços utilizados
            </span>
        </div>

        {{-- LISTA --}}
        <div class="space-y-4 mb-8">
            @forelse ($user->enderecos as $endereco)
                <div class="border rounded-xl p-4 flex flex-col sm:flex-row justify-between gap-4">
                    <p class="text-sm text-gray-700">
                        {{ $endereco->endereco_completo }}
                    </p>

                    <div class="flex gap-2">
                        <a
                            href="javascript:void(0)"
                            onclick="abrirModalEndereco('edit', {{ json_encode($endereco) }})"
                            class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
                        >
                            Editar
                        </a>

                        <button
                            type="button"
                            onclick="confirmarExclusaoEndereco({{ $endereco->id }})"
                            class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
                        >
                            Excluir
                        </button>

                        <form
                            id="delete-endereco-{{ $endereco->id }}"
                            action="{{ route('enderecos.destroy', $endereco->id) }}"
                            method="POST"
                            class="hidden"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">
                    Nenhum endereço cadastrado.
                </p>
            @endforelse
        </div>

        {{-- BOTÃO NOVO ENDEREÇO (Controlado pelo Limite) --}}
        @if ($user->enderecos->count() < 5)
            <button 
                onclick="abrirModalEndereco('create')"
                class="w-full py-3 rounded-xl border-2 border-dashed border-gray-300 text-gray-500 hover:border-primary hover:text-primary transition flex items-center justify-center gap-2 font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Adicionar Novo Endereço
            </button>
        @else
            <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-sm">Limite de endereços atingido. Exclua um endereço para adicionar outro.</p>
            </div>
        @endif
    </div>
</div>

{{-- MODAL DE ENDEREÇO (Create/Edit) --}}
<div id="modal-endereco" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="fecharModalEndereco()"></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                    Gerenciar Endereço
                </h3>

                <form id="form-endereco" action="{{ route('enderecos.store') }}" method="POST" class="space-y-5">
                    @csrf
                    {{-- Método Spoofing para Edit (será injetado via JS se necessário) --}}
                    <div id="method-spoof"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rua</label>
                            <input name="rua" id="input-rua" required class="input" value="{{ old('rua') }}" placeholder="Ex: Av. Paulista">
                            @error('rua') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                            <input name="numero" id="input-numero" required class="input" value="{{ old('numero') }}" placeholder="123">
                            @error('numero') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
                            <input name="complemento" id="input-complemento" class="input" value="{{ old('complemento') }}" placeholder="Apto 101">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                            <input name="bairro" id="input-bairro" required class="input" value="{{ old('bairro') }}" placeholder="Centro">
                            @error('bairro') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                            <input name="cidade" id="input-cidade" required class="input" value="{{ old('cidade') }}" placeholder="São Paulo">
                            @error('cidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <input name="estado" id="input-estado" required class="input" value="{{ old('estado') }}" placeholder="SP">
                            @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                            <input name="cep" id="input-cep" required class="input" value="{{ old('cep') }}" placeholder="00000-000" maxlength="9">
                            @error('cep') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" class="btn-primary w-full sm:col-start-2">Salvar</button>
                        <button type="button" onclick="fecharModalEndereco()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarExclusaoConta() {
    Swal.fire({
        title: 'Excluir conta?',
        text: 'Essa ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-conta').submit();
        }
    });
}

function confirmarExclusaoEndereco(id) {
    Swal.fire({
        title: 'Excluir endereço?',
        text: 'Deseja remover este endereço?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-endereco-${id}`).submit();
        }
    });
}

// Lógica do Modal de Endereço
const modal = document.getElementById('modal-endereco');
const form = document.getElementById('form-endereco');
const methodSpoof = document.getElementById('method-spoof');
const modalTitle = document.getElementById('modal-title');

function abrirModalEndereco(mode, data = null) {
    modal.classList.remove('hidden');
    
    // Limpar campos
    form.reset();
    methodSpoof.innerHTML = '';
    
    // Remover erros de validação antigos visualmente (opcional)
    document.querySelectorAll('.text-red-500').forEach(el => el.remove());

    if (mode === 'create') {
        modalTitle.innerText = 'Adicionar Novo Endereço';
        form.action = "{{ route('enderecos.store') }}";
    } else if (mode === 'edit' && data) {
        modalTitle.innerText = 'Editar Endereço';
        
        // Define a rota de update substituindo o ID
        let updateUrl = "{{ route('enderecos.update', ':id') }}";
        form.action = updateUrl.replace(':id', data.id);
        
        // Adiciona o campo hidden @method('PUT')
        methodSpoof.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        // Preenche os campos
        document.getElementById('input-rua').value = data.rua;
        document.getElementById('input-numero').value = data.numero;
        document.getElementById('input-complemento').value = data.complemento || '';
        document.getElementById('input-bairro').value = data.bairro;
        document.getElementById('input-cidade').value = data.cidade;
        document.getElementById('input-estado').value = data.estado;
        document.getElementById('input-cep').value = data.cep;
    }
}

function fecharModalEndereco() {
    modal.classList.add('hidden');
}

// Máscara de CEP
const cepInput = document.getElementById('input-cep');
if(cepInput) {
    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        if (value.length > 8) value = value.slice(0, 8); // Limita a 8 dígitos
        
        if (value.length > 5) {
            value = value.replace(/^(\d{5})(\d)/, '$1-$2'); // Coloca o hífen
        }
        e.target.value = value;
    });
}

// Intercepta o envio do formulário para confirmação e prevenção de duplo clique
form.addEventListener('submit', function(e) {
    e.preventDefault(); // Impede o envio imediato

    // Verifica se é edição ou criação para mudar o texto
    const isEdit = methodSpoof.innerHTML.includes('PUT');
    const actionText = isEdit ? 'Atualizar' : 'Cadastrar';

    Swal.fire({
        title: `${actionText} Endereço?`,
        text: "Verifique se os dados estão corretos.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb', // blue-600
        cancelButtonColor: '#9ca3af', // gray-400
        confirmButtonText: `Sim, ${actionText}`,
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostra loading e bloqueia a tela
            Swal.fire({
                title: 'Salvando...',
                text: 'Por favor, aguarde.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            form.submit(); // Envia o formulário manualmente
        }
    });
});

// Reabrir modal se houver erros de validação (Laravel)
@if ($errors->any())
    modal.classList.remove('hidden');
@endif
</script>

<style>
.input {
    @apply w-full rounded-lg border-0 py-2.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all duration-200;
}

.btn-primary {
    @apply inline-flex justify-center items-center rounded-lg bg-primary px-6 py-2.5 text-white font-semibold hover:opacity-90 transition;
}

.btn-danger {
    @apply inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-2.5 text-white font-semibold hover:bg-red-700 transition;
}
</style>
@endsection
