@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'model' ])

    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('model_type', $filters['model-type'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('model_type', Lang::get('general.model_type'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vendor', $filters['vendor'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('vendor', Lang::get('general.vendor'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('name', $filters['name'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

@stop
