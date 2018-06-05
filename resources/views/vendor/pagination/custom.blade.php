@if ($paginator->hasPages())
    <ul class="pager">
         {{--Previous Page Link--}}
        
        @if ($paginator->onFirstPage())
			<li class="disabled"><a href="{{ $paginator->url(1)}}" rel="prev">{{trans('common.pagination.first')}}</a></li>
            <li class="disabled"><span>{{trans('common.pagination.previous')}}</span></li>
        @else
			<li><a href="{{ $paginator->url(1)}}" rel="prev">{{trans('common.pagination.first')}}</a></li>
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{trans('common.pagination.previous')}}</a></li>
        @endif

        {{--element--}}
        @if($paginator->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="disabled"><span>...</span></li>
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
            <li class="disabled"><span>...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

         {{--Next Page Link--}}
        @if ($paginator->hasMorePages())
			<li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{trans('common.pagination.next')}}</a></li>
			<li><a href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">{{trans('common.pagination.last')}}</a></li>
        @else
            <li class="disabled"><span>{{trans('common.pagination.next')}}</span></li>
			<li class="disabled"><a href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">{{trans('common.pagination.last')}}</a></li>
        @endif
        
    </ul>
@endif