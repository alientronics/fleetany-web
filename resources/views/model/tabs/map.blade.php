	<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
		<div class="mdl-button mdl-button--colored">
	        {{Lang::get('general.VehicleMap')}}
		</div>
		
		<div class="mdl-card__actions mdl-card--border"></div>
	    <div class="mdl-card__supporting-text" style="height: 900px;">
	    	<div class="mdl-color-text--grey tires-front">
	    		<span>(</span>
	    	</div>
	    	
	    	<input type="hidden" name="tires_fillable" id="tires_fillable" value="{{json_encode(str_split('0'.$model->map))}}" />
	    	
    	@if(!empty(str_split($model->map)))
    		{{--*/ $col = 0; /*--}}
    		@foreach(str_split($model->map) as $key => $value)
    			
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
    		    
    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif tire-position-fillable mdl-cell mdl-cell--2-col">
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

	<div class="mdl-card__actions">
		<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
	</div>