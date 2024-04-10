@vite(['resources/scss/base.scss'])
<ul class="paginate">
    @if ($items->lastPage() > 1)
        <li class="arrow-paginate">
            <a href="{{ $items->previousPageUrl() }}" rel="prev">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>
        <li class="{{ $items->currentPage() == 1 ? ' paginate-active' : '' }}">
            <a href="{{ $items->url($items->onFirstPage()) }}">1</a>
        </li>
        <?php
        $start = $items->currentPage() - 2;
        $end = $items->currentPage() + 2;
        if ($start < 1) {
            $start = 1;
            $end += 1;
        }
        if ($end >= $items->lastPage()) {
            $end = $items->lastPage();
        }
        ?>
        @if ($items->currentPage() > 3)
            <li><span>...</span></li>
        @endif
        @for ($i = $start + 1; $i < $end; $i++)
            <li class="{{ $items->currentPage() == $i ? ' paginate-active' : '' }}">
                <a href="{{ $items->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        @if ($items->currentPage() + 2 < $items->lastPage())
            <li><span>...</span></li>
        @endif
        <li class="{{ $items->currentPage() == $items->lastPage() ? ' paginate-active' : '' }}">
            <a href="{{ $items->url($items->lastPage()) }}">{{ $items->lastPage() }}</a>
        </li>
        <li class="arrow-paginate">
            <a href="{{ $items->nextPageUrl() }}" rel="next">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
    @endif
</ul>
