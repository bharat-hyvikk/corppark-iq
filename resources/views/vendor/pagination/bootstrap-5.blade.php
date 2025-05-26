@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>
            {{-- <p class="fw-semibold mb-0 text-dark text-sm">
                {!! __('Page') !!}{{ $paginator->currentPage() }}
                {!! __('of') !!}
                {{ $paginator->lastPage() }}
            </p>               --}}
      
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div style="color:#334155">
                <p class="fw-semibold" style="margin-left:20px">
                    {!! __('Page') !!}
                    <span class="fw-semibold">{{ $paginator->currentPage() }}</span>
                    {!! __('of') !!}
                    <span class="fw-semibold">{{ $paginator->lastPage() }}</span>
                </p>
                
            </div>            

            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <button class="btn fw-semibold  btn-white mb-0" disabled>
                                Previous
                            </button>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-white mb-0 fw-semibold" rel="prev" aria-label="@lang('pagination.previous')">
                                Previous
                            </a>
                            
                        </li>
                    @endif


                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link text-light fw-bold">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item" style="margin-right: 10px;">
                            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-white mb-0 fw-semibold" rel="next" aria-label="@lang('pagination.next')">
                                Next
                            </a>      
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')" style="margin-right: 10px;">
                            <button class="btn fw-semibold btn-white mb-0" disabled>
                                Next
                            </button>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
@endif
