      @permission('create.'.$pageActive)
      <a href="{{url('/')}}/{{$pageActive}}/create" class="mdl-cell--hide-tablet mdl-cell--hide-phone button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
        <i class="material-icons">add</i>
      </a>
      <a href="{{url('/')}}/{{$pageActive}}/create" class="mdl-cell--hide-desktop button mdl-add__button mdl-button mdl-js-button mdl-js-ripple-effect">
        <i class="material-icons">add</i>
      </a>
      @endpermission

    <button class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary mdl-button--search">
      <i class="material-icons">filter_list</i>
    </button>

    <button class="mdl-cell--hide-desktop mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--search">
      <i class="material-icons">filter_list</i>
    </button>