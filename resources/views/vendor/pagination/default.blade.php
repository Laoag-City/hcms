@if ($paginator->hasPages())
    <div class="ui huge pagination menu">
        {{-- Previous Page divnk --}}
        @if ($paginator->onFirstPage())
            <div class="disabled item"><i class="chevron circle left icon"></i></div>
        @else
            <a class="item" href="{{ $paginator->previousPageUrl() }}"><i class="chevron circle left icon"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="disabled item">{{ $element }}</div>
            @endif

            {{-- Array Of divnks --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="active item"><b>{{ $page }}</b></div>
                    @else
                        <a class="item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page divnk --}}
        @if ($paginator->hasMorePages())
            <a class="item" href="{{ $paginator->nextPageUrl() }}"><i class="chevron circle right icon"></i></a>
        @else
            <div class="disabled item"><i class="chevron circle right icon"></i></div>
        @endif
    </div>
@endif