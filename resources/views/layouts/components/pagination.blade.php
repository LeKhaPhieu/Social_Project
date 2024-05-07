@vite(['resources/scss/base.scss'])
@vite(['resources/admin/css/font-awesome.css'])
<ul class="paginate">
    @if ($paginator->lastPage() > 1)
        <li class="arrow-paginate">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="fa fa-angle-left"></i>
            </a>
        </li>
        <li class="{{ $paginator->currentPage() == 1 ? ' paginate-active' : '' }}">
            <a href="{{ $paginator->url($paginator->onFirstPage()) }}">1</a>
        </li>
        <?php
        $start = $paginator->currentPage() - 2;
        $end = $paginator->currentPage() + 2;
        if ($start < 1) {
            $start = 1;
            $end += 1;
        }
        if ($end >= $paginator->lastPage()) {
            $end = $paginator->lastPage();
        }
        ?>
        @if ($paginator->currentPage() > 3)
            <li><span>...</span></li>
        @endif
        @for ($i = $start + 1; $i < $end; $i++)
            <li class="{{ $paginator->currentPage() == $i ? ' paginate-active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        @if ($paginator->currentPage() + 2 < $paginator->lastPage())
            <li><span>...</span></li>
        @endif
        <li class="{{ $paginator->currentPage() == $paginator->lastPage() ? ' paginate-active' : '' }}">
            <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        </li>
        <li class="arrow-paginate">
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    @endif
</ul>
