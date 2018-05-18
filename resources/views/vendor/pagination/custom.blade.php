@if ($paginator->hasPages())
    <ul class="pager">
         {{--Previous Page Link--}}
        <li><a href="{{ $paginator->url(1)}}" rel="prev">← First</a></li>
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>← Previous</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li>
        @endif

        {{--element--}}
        @if($paginator->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

         {{--Next Page Link--}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a></li>
        @else
            <li class="disabled"><span>Next →</span></li>
        @endif
        <li><a href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">Last →</a></li>
    </ul>
@endif