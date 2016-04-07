@if ($paginator->lastPage() > 1)
<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    <div class="mdl-paging"><span class="mdl-paging__per-page"><span class="mdl-paging__per-page-label">Resultados por p&aacute;gina:</span><span class="mdl-paging__per-page-value">{{$paginator->perPage()}}</span>
        <button id="HkhZcTBbWFADje7t2" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-paging__per-page-dropdown"><i class="material-icons">arrow_drop_down</i>
        </button>
        <ul for="HkhZcTBbWFADje7t2" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-js-ripple-effect--ignore-events">
          <li tabindex="-1" data-value="10" class="mdl-menu__item mdl-js-ripple-effect"><a href="{{ $paginator->url($paginator->currentPage()) . '&paginate=10'}}">10</a></span>
          </li>
          <li tabindex="-1" data-value="20" class="mdl-menu__item mdl-js-ripple-effect"><a href="{{ $paginator->url($paginator->currentPage()) . '&paginate=20'}}">20</a></span>
          </li>
          <li tabindex="-1" data-value="30" class="mdl-menu__item mdl-js-ripple-effect"><a href="{{ $paginator->url($paginator->currentPage()) . '&paginate=30'}}">30</a></span>
          </li>
          <li tabindex="-1" data-value="40" class="mdl-menu__item mdl-js-ripple-effect"><a href="{{ $paginator->url($paginator->currentPage()) . '&paginate=40'}}">40</a></span>
          </li>
          <li tabindex="-1" data-value="50" class="mdl-menu__item mdl-js-ripple-effect"><a href="{{ $paginator->url($paginator->currentPage()) . '&paginate=50'}}">50</a></span>
          </li>
        </ul>
        </span><span class="mdl-paging__count">{{$paginator->perPage() * $paginator->currentPage() - ($paginator->perPage() - 1)}}-{{$paginator->perPage() * $paginator->currentPage()}} de {{$paginator->total()}}</span>
        
        @if ($paginator->currentPage() != 1)
        <a href="{{ $paginator->url($paginator->currentPage()-1) . '&paginate='.$filters['paginate']}}" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-paging__prev"><i class="material-icons">keyboard_arrow_left</i>
        </a>
        @endif
        @if ($paginator->currentPage() != $paginator->lastPage())
        <a href="{{ $paginator->url($paginator->currentPage()+1) . '&paginate='.$filters['paginate']}}" class="button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-paging__next"><i class="material-icons">keyboard_arrow_right</i>
        </a>
        @endif
    </div>
</div>
@endif
