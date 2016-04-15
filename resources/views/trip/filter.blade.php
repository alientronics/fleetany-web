@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'trip' ])
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vehicle', $filters['vehicle'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('vehicle', Lang::get('general.vehicle'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('trip_type', $filters['trip-type'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('trip_type', Lang::get('general.trip_type'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('pickup_date', $filters['pickup-date'], ['id' => 'pickup_date', 'class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('pickup_date', Lang::get('general.pickup_date'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('fuel_cost', $filters['fuel-cost'], ['id' => 'fuel_cost', 'class' => 'mdl-textfield__input mdl-search__input mdl-textfield__maskmoney'])!!}
    		{!!Form::label('fuel_cost', Lang::get('general.fuel_cost'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

	<script>
        (function() {
            var x = new mdDateTimePicker({
              type: 'date',
        		future: moment().add(21, 'years')
            });
            $('#pickup_date')[0].addEventListener('click', function() {
        		x.trigger($('#pickup_date')[0]);
        		$('#pickup_date').parent().addClass('is-dirty');
              x.toggle();
            });
            // dispatch event test
            $('#pickup_date')[0].addEventListener('onOk', function() {
              this.value = x.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
            });
        }).call(this);
    	$( document ).ready(function() {
    		$('#fuel_cost').maskMoney({!!Lang::get("masks.money")!!});
    	});
    </script>
    
@stop
