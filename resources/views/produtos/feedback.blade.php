@extends('user.dashboard')

@section('title', 'Avaliar Produto')

@section('dashboard')
@include('user.dashboard-content')

<div class="mx-auto max-w-2xl px-4 py-12">
    {{-- Cartão Principal --}}
    <div class="overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-gray-900/5">
        
        {{-- Cabeçalho do Produto --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-8 py-10 text-center text-white">
            <h1 class="text-2xl font-bold tracking-tight text-amber-400">Avalie sua experiência</h1>
            <p class="mt-2 text-gray-300">Como foi sua compra do produto abaixo?</p>
            
            <div class="mt-6 flex flex-col items-center">
                @if($produto->imagem)
                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="h-24 w-24 rounded-xl object-cover shadow-lg ring-2 ring-amber-500/50">
                @endif
                <h2 class="mt-4 text-xl font-semibold">{{ $produto->nome }}</h2>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="p-8">
            @if(session('aviso'))
                <div class="mb-6 rounded-xl bg-amber-50 p-4 text-amber-800 border border-amber-200">
                    {{ session('aviso') }}
                </div>
            @endif

            <form method="POST" action="{{ route('feedback.store') }}" class="space-y-8">
                @csrf
                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                <input type="hidden" name="slug" value="{{ $produto->slug }}">

                {{-- Seleção de Estrelas --}}
                <div class="text-center">
                    <label class="mb-4 block text-sm font-medium text-gray-700">Quantas estrelas este produto merece?</label>
                    
                    <div class="flex justify-center gap-4 flex-row-reverse group">
                        @for($i=5; $i>=1; $i--)
                            <input type="radio" name="rating" id="star{{$i}}" value="{{$i}}" class="peer hidden" required />
                            <label for="star{{$i}}" class="cursor-pointer text-4xl text-gray-300 transition-colors peer-checked:text-amber-400 hover:text-amber-400 peer-hover:text-amber-400">
                                ★
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comentário --}}
                <div>
                    <label for="comment" class="mb-2 block text-sm font-medium text-gray-700">Seu comentário (opcional)</label>
                    <textarea 
                        name="comment" 
                        id="comment"
                        rows="4"
                        placeholder="Conte-nos o que você gostou ou não gostou..."
                        class="w-full rounded-xl border-gray-200 bg-gray-50 p-4 text-gray-900 placeholder-gray-400 focus:border-amber-500 focus:bg-white focus:ring-amber-500"
                    ></textarea>
                </div>

                {{-- Botões de Ação --}}
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('show.detalhes', $produto->slug) }}" 
                       class="flex-1 rounded-xl border border-gray-300 bg-white px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="flex-1 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:from-amber-600 hover:to-amber-700 hover:shadow-amber-500/50">
                        Enviar Avaliação
                    </button>
                </div>
            </form>

            {{-- Lista de Avaliações Anteriores --}}
            <div class="mt-12 border-t border-gray-100 pt-10">
                <h3 class="mb-6 text-lg font-bold text-gray-900">Avaliações da Comunidade</h3>

                <div class="space-y-6">
                    @if(isset($produto->feedbacks) && $produto->feedbacks->count() > 0)
                        @foreach($produto->feedbacks as $feedback)
                            <div class="flex gap-4">
                                {{-- Avatar / Inicial --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-gray-200 to-gray-300 font-bold text-gray-600 shadow-sm">
                                    {{ substr($feedback->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-900">{{ $feedback->user->name ?? 'Anônimo' }}</h4>
                                        <span class="text-xs text-gray-500">{{ $feedback->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    
                                    {{-- Exibição das Estrelas --}}
                                    <div class="flex text-sm text-amber-400">
                                        @for($s=1; $s<=5; $s++)
                                            <span class="{{ $s <= $feedback->rating ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>

                                    {{-- Balão de Comentário --}}
                                    @if($feedback->comment)
                                        <div class="mt-2 inline-block rounded-2xl rounded-tl-none bg-gray-50 px-4 py-3 text-sm text-gray-700 shadow-sm ring-1 ring-gray-900/5">
                                            {{ $feedback->comment }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="rounded-xl bg-gray-50 p-6 text-center text-gray-500">
                            <p>Ainda não há avaliações para este produto. Seja o primeiro!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
