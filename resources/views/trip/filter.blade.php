@section('filter')

    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-button--search">
      <i class="material-icons">filter_list</i>
    </button>
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--amber mdl-color-text--white">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vehicle', $filters['vehicle'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('vehicle', Lang::get('general.vehicle'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('trip_type', $filters['trip-type'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('trip_type', Lang::get('general.trip_type'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('pickup_date', $filters['pickup-date'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('pickup_date', Lang::get('general.pickup_date'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('fuel_cost', $filters['fuel-cost'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('fuel_cost', Lang::get('general.fuel_cost'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

@stop
