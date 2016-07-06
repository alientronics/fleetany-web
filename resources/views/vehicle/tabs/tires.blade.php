  <dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
        
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('part_model_id')) is-invalid is-dirty @endif"">
            {!!Form::select('part_model_id', $tiresModels, 1, ['id' => 'part_model_id', 'class' => 'mdl-textfield__input'])!!}
   			{!!Form::label('part_model_id', Lang::get('general.part_model'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('part_model_id') }}</span>
        </div>
        
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('part_number', "", ['id' => 'part_number', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('part_number', Lang::get('general.part_number'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
		</div>   
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('part_miliage', "", ['id' => 'part_miliage', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('part_miliage', Lang::get('general.miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('miliage') }}</span>
		</div>  
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('lifecycle')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('part_lifecycle', "", ['id' => 'part_lifecycle', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('part_lifecycle', Lang::get('general.lifecycle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('lifecycle') }}</span>
		</div> 
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button create-tire">{{Lang::get('general.Submit')}}</button>
      <button type="button" class="mdl-button close">{{Lang::get('general.Close')}}</button>
    </div>
  </dialog>

<div class="mdl-grid demo-content">

	<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
		<div class="mdl-button mdl-button--colored">
	        {{Lang::get('general.VehicleMap')}}
		</div>
		
		<div class="mdl-card__actions mdl-card--border"></div>
	    <div class="mdl-card__supporting-text" style="height: 900px;">
	    	<div class="mdl-color-text--grey tires-front">
	    		<span>(</span>
	    	</div>
	    	
    	@if(!empty(str_split($vehicle->model->map)))
    		{{--*/ $col = 0; /*--}}
    		@foreach(str_split($vehicle->model->map) as $key => $value)

    			@if($col == 4)
	    		{{--*/ $col = 1; /*--}}
	    		@else
	    		{{--*/ $col++; /*--}}
				@endif
					    	
	    		@if($col == 1)
    	    	<div class="mdl-grid" style="height: 100px;">
    		    	<div class="mdl-cell mdl-cell--1-col">
    		    		&nbsp;
    		    	</div>
    		    @endif
    		    
    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) @if(!empty($tiresPositions[$key + 1])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif @endif mdl-cell mdl-cell--2-col">
    		    		&nbsp;
    		    	</div>
    		    	
    		    @if($col == 2)
    	    		<div class="mdl-cell mdl-cell--2-col">
    		    		&nbsp;
    		    	</div>
    		    @endif	
    		    	
    		    @if($col == 4)
	    		</div>
    		    @endif	
    		    
    		@endforeach    	
		@endif
	    	<div class="mdl-color-text--grey tires-back">
	    		<span>]</span>
	    	</div>
	    </div>
	</div>

	<div class="mdl-cell mdl-cell--6-col mdl-grid mdl-grid--no-spacing">

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TirePositionDetail')}}
			</div>
			
			<input id="tire-position-swap-flag" type="hidden" value="0" />
			<input id="tire-position-focus-id" type="hidden" value="0" />
			<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
			<input id="part-type-id" type="hidden" value="{{$part_type_id}}" />
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-position-detail" style="height: 200px;">
		    	<div id="tire-position-detail-data"></div>
                	
                <div class="tires-buttons-bottom">	    	
                	<button id="tire-position-swap" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary tire-position-detail-button">
                      <i class="material-icons">swap_horiz</i>
                    </button>
                    <button id="tire-position-remove" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary tire-position-detail-button">
                      <i class="material-icons">arrow_downward</i>
                    </button>
		    	</div>
		    </div>
		</div>

		<div class="mdl-cell--1-col" style="height: 32px;"></div>

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TireStorage')}}
			</div>
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-storage">
                <div class="tires-buttons-top">	   
                    <button id="tire-add" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
                      <i class="material-icons">add</i>
                    </button>
                    <button id="tire-position-add" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
                      <i class="material-icons">arrow_upward</i>
                    </button>
                </div>
		    	<div id="tire-storage-data">
		    	
    		    	@include('vehicle.tabs.tiresstorage', [
                    	'tires' => $tires
                    ])
		    	
		    	</div>
		    	
		    </div>
		</div>
		
		<div class="mdl-cell--1-col" style="height: 32px;"></div>

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TireStorageDetail')}}
			</div>
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-storage-detail">
		    	<div id="tire-storage-detail-data"></div>
		    </div>
		</div>

	</div>

</div>
