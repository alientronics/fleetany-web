@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'entry' ])
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vehicle', $filters['vehicle'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('vehicle', Lang::get('general.vehicle'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('entry_type', $filters['entry-type'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('entry_type', Lang::get('general.entry_type'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('datetime_ini', $filters['datetime-ini'], ['id' => 'datetime_ini', 'class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('datetime_ini', Lang::get('general.datetime_ini'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('cost', $filters['cost'], ['id' => 'cost', 'class' => 'mdl-textfield__input mdl-search__input mdl-textfield__maskmoney'])!!}
    		{!!Form::label('cost', Lang::get('general.cost'), ['class' => 'mdl-textfield__label is-dirty'])!!}
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
            $('#datetime_ini')[0].addEventListener('click', function() {
        		x.trigger($('#datetime_ini')[0]);
        		$('#datetime_ini').parent().addClass('is-dirty');
              x.toggle();
            });
            // dispatch event test
            $('#datetime_ini')[0].addEventListener('onOk', function() {
              this.value = x.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
            });
        }).call(this);
    	$( document ).ready(function() {
    		$('#cost').maskMoney({!!Lang::get("masks.money")!!});
    	});
    </script>
    
@stop
