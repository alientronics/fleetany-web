@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'part' ])
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('name', $filters['name'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('number', $filters['number'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('number', Lang::get('general.part_number'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('position', $filters['position'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('position', Lang::get('general.position'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('vehicle', $filters['vehicle'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('vehicle', Lang::get('general.vehicle'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('part_type', $filters['part-type'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('part_type', Lang::get('general.part_type'), ['class' => 'mdl-textfield__label is-dirty'])!!}
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
    	$( document ).ready(function() {
    		$('#cost').maskMoney({!!Lang::get("masks.money")!!});
    	});
    </script>
    
@stop
