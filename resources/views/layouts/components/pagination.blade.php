@vite(['resources/scss/base.scss'])
@vite(['resources/admin/css/font-awesome.css'])
<ul class="paginate">
    @if ($posts->lastPage() > 1)
        <li class="arrow-paginate">
            <a href="{{ $posts->previousPageUrl() }}" rel="prev">
                <i class="fa fa-angle-left"></i>
            </a>
        </li>
        <li class="{{ $posts->currentPage() == 1 ? ' paginate-active' : '' }}">
            <a href="{{ $posts->url($posts->onFirstPage()) }}">1</a>
        </li>
        <?php
        $start = $posts->currentPage() - 2;
        $end = $posts->currentPage() + 2;
        if ($start < 1) {
            $start = 1;
            $end += 1;
        }
        if ($end >= $posts->lastPage()) {
            $end = $posts->lastPage();
        }
        ?>
        @if ($posts->currentPage() > 3)
            <li><span>...</span></li>
        @endif
        @for ($i = $start + 1; $i < $end; $i++)
            <li class="{{ $posts->currentPage() == $i ? ' paginate-active' : '' }}">
                <a href="{{ $posts->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        @if ($posts->currentPage() + 2 < $posts->lastPage())
            <li><span>...</span></li>
        @endif
        <li class="{{ $posts->currentPage() == $posts->lastPage() ? ' paginate-active' : '' }}">
            <a href="{{ $posts->url($posts->lastPage()) }}">{{ $posts->lastPage() }}</a>
        </li>
        <li class="arrow-paginate">
            <a href="{{ $posts->nextPageUrl() }}" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    @endif
</ul>
