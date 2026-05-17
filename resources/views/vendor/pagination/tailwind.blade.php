@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Mobile --}}
        <div class="flex items-center justify-between gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-blue-300 bg-blue-50 border border-blue-200 rounded-xl cursor-default">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Anterior
                </a>
            @endif
            <span class="text-sm font-semibold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link">
                    Próximo
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-blue-300 bg-blue-50 border border-blue-200 rounded-xl cursor-default">
                    Próximo
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:flex-col sm:items-center gap-4">
            <div class="flex items-center gap-1.5">
                @if ($paginator->onFirstPage())
                    <span class="flex items-center justify-center w-10 h-10 text-blue-300 bg-blue-50 border border-blue-200 rounded-xl cursor-default">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link" aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                @endif

                @php
                    $current = $paginator->currentPage();
                    $last = $paginator->lastPage();
                    $start = max(1, $current - 1);
                    $end = min($last, $current + 1);
                    if ($current <= 2) { $end = min(3, $last); }
                    if ($current >= $last - 1) { $start = max(1, $last - 2); }
                @endphp

                @if ($start > 1)
                    <a href="{{ $paginator->url(1) }}" class="flex items-center justify-center w-10 h-10 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link">1</a>
                    @if ($start > 2)
                        <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl">...</span>
                    @endif
                @endif

                @foreach (range($start, $end) as $page)
                    @if ($page == $current)
                        <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-blue-600 border-2 border-blue-600 rounded-xl shadow-md">{{ $page }}</span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="flex items-center justify-center w-10 h-10 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($end < $last)
                    @if ($end < $last - 1)
                        <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl">...</span>
                    @endif
                    <a href="{{ $paginator->url($last) }}" class="flex items-center justify-center w-10 h-10 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link">{{ $last }}</a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 hover:border-blue-300 transition paginate-link" aria-label="{{ __('pagination.next') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <span class="flex items-center justify-center w-10 h-10 text-blue-300 bg-blue-50 border border-blue-200 rounded-xl cursor-default">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif
            </div>

            <p class="text-sm text-gray-500">
                Mostrando
                <span class="font-medium text-gray-900">{{ $paginator->firstItem() }}</span>
                até
                <span class="font-medium text-gray-900">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-medium text-gray-900">{{ $paginator->total() }}</span>
                resultados
            </p>
        </div>
    </nav>

    <script>
    (function() {
        var links = document.querySelectorAll('.paginate-link');
        var main = document.querySelector('.max-w-7xl') || document.querySelector('main') || document.body;
        if (!links.length) return;

        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function(e) {
                e.preventDefault();
                var href = this.getAttribute('href');
                if (!href) return;
                main.style.transition = 'opacity 0.15s ease-out, transform 0.15s ease-out';
                main.style.opacity = '0';
                main.style.transform = 'translateY(4px)';
                setTimeout(function() { window.location = href; }, 150);
            });
        }

        main.style.opacity = '0';
        main.style.transform = 'translateY(4px)';
        requestAnimationFrame(function() {
            main.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            main.style.opacity = '1';
            main.style.transform = 'translateY(0)';
        });
    })();
    </script>
@endif