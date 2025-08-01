<nav>
    <ul class="pagination"> {{-- bisa kamu ganti dengan class kamu sendiri --}}
        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <li><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}">&laquo;</a></li>
        @endif

        {{-- Link Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Selanjutnya --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">&raquo;</a></li>
        @else
            <li><span>&raquo;</span></li>
        @endif
    </ul>
</nav>
