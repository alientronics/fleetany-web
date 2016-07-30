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
		{{--*/ 
			$col = 0; 
			$final = false;
		/*--}}
		
		@foreach(str_split($vehicle->model->map) as $key => $value)

			@if(($tiresPositions['max_position'] > $key || $col != 4) && !$final)
			
				@if($tiresPositions['max_position'] <= $key && $col == 4)
					{{--*/ 
						$final = true;
						break;
					/*--}}
				@endif

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
    		    
    		    	@if(!empty($pageActive) && $pageActive == 'vehicleShow')
    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) @if(!empty($tiresPositions[$key + 1])) mdl-color--green @else mdl-color--grey @endif @endif tires-show mdl-cell mdl-cell--2-col">
    	    		@else
    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) @if(!empty($tiresPositions[$key + 1])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif @endif mdl-cell mdl-cell--2-col">
    		    	@endif
    		    		<div class="@if(strlen($key + 1) > 1) vehicle-map-tire-number @else vehicle-map-tire-number-simple @endif">{{$key + 1}}</div>
    		    	</div>
    		    	
    		    @if($col == 2)
    	    		<div class="mdl-cell mdl-cell--2-col">
    		    		&nbsp;
    		    	</div>
    		    @endif	
    		    	
    		    @if($col == 4)
        		</div>
    		    @endif
		    @endif	
		    
		@endforeach    	
	@endif
    	<div class="mdl-color-text--grey tires-back">
    		<span>]</span>
    	</div>
    </div>
</div>