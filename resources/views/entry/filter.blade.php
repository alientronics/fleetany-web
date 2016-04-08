@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'entry' ])
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vehicle', $filters['vehicle'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('vehicle', Lang::get('general.vehicle'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('entry_type', $filters['entry-type'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('entry_type', Lang::get('general.entry_type'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('datetime_ini', $filters['datetime-ini'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('datetime_ini', Lang::get('general.datetime_ini'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('cost', $filters['cost'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('cost', Lang::get('general.cost'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

@stop
