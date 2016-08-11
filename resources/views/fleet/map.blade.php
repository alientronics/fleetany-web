<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
	<div class="mdl-button mdl-button--colored">
        {{Lang::get("general.fleet_number")}}: {{$vehicle->fleet}} - {{Lang::get("general.number")}}: {{$vehicle->number}}
	</div>
	
	<div class="mdl-card__actions mdl-card--border"></div>
    <div class="mdl-card__supporting-text" style="height: 900px;">
    	<div class="mdl-color-text--grey tires-front">
    		<span>(</span>
    	</div>
    	
	@if(!empty(str_split($modelMap)))
		{{--*/ 
			$col = 0; 
			$final = false;
		/*--}}
		
		@foreach(str_split($modelMap) as $key => $value)

			@if((strripos($modelMap,'1') > $key || $col != 4) && !$final)
			
				@if(strripos($modelMap,'1') <= $key && $col == 4)
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
    		    
    		    	<div id="pos{{$key + 1}}_{{$vehicle->id}}" class="@if($value == 1) @if(isset($tireData[$key + 1])) mdl-color--green @else mdl-color--grey @endif @endif tires-fleet mdl-cell mdl-cell--2-col">
    		    	@if($value == 1)
    		    		<div class="@if(strlen($key + 1) > 1) vehicle-map-tire-number @else vehicle-map-tire-number-simple @endif">{{$key + 1}}</div>
                        @if(!empty($tireData[$key + 1]->pressure) || !empty($tireData[$key + 1]->temperature))
                        <div class="mdl-tooltip" id="tireData{{$key + 1}}_{{$vehicle->id}}" for="pos{{$key + 1}}_{{$vehicle->id}}">
                        {{Lang::get("general.pressure")}}: {{$tireData[$key + 1]->pressure}} - {{Lang::get("general.temperature")}}: {{$tireData[$key + 1]->temperature}}
                        </div>
                        @endif
    		    	@endif
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