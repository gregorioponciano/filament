@extends('user.dashboard')

@section('title', 'Perfil')

@section('dashboard')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Mensagem de sucesso --}}
    @if (session('sucesso'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
            {{ session('sucesso') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Meu Perfil
        </h1>

        {{-- FORM ATUALIZAR PERFIL --}}
        <form 
            action="{{ route('store.profile', ['id' => $user->id]) }}" 
            method="POST"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome
                </label>
                <input
                    type="text"
                    name="name"
                    id="nome"
                    value="{{ $user->name }}"
                    required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary px-4 py-2"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ $user->email }}"
                    required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary px-4 py-2"
                >
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-between pt-4">
                <button
                    type="submit"
                    class="inline-flex justify-center items-center rounded-lg bg-primary px-6 py-2.5 text-white font-semibold hover:opacity-90 transition"
                >
                    Atualizar Perfil
                </button>

                <button
                    type="button"
                    onclick="confirmarExclusao()"
                    class="inline-flex justify-center items-center rounded-lg bg-red-600 px-6 py-2.5 text-white font-semibold hover:bg-red-700 transition"
                >
                    Excluir Conta
                </button>
            </div>
        </form>

        {{-- FORM DELETE (oculto) --}}
        <form 
            id="form-delete"
            action="{{ route('destroy.profile', ['id' => $user->id]) }}"
            method="POST"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarExclusao() {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Essa ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete').submit();
        }
    });
}
</script>
@endsection
