<div class="mdl-grid demo-content">
	<div class="md-cell mdl-cell--3-col"></div> 
    	<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
    		<div class="mdl-button mdl-button--colored">
    	        {{Lang::get('general.VehicleMap')}}
    		</div>
    		
    		<div class="mdl-card__actions mdl-card--border"></div>
    	    <div class="mdl-card__supporting-text">
    	    	<div class="mdl-color-text--grey tires-front">
    	    		<span>(</span>
    	    	</div>
    	    	
    	    	<input type="hidden" name="tires_fillable" id="tires_fillable" value="{{json_encode(str_split('0'.$model->map))}}" />
    	    	
            	@if(!empty(str_split($model->map)))
            		{{--*/ $map = str_split('0'.$model->map); /*--}}
            	@endif
            	
        		{{--*/ $col = 0; /*--}}
        		@for($i = 1; $i < 57; $i++)
        			
        			
        			@if($i == 17)
            	    	<div class="mdl-color-text--grey tires-back">
            	    		<span>]</span>
            	    	</div>
            	    	<div class="mdl-color-text--grey tires-back">
            	    		<span>[</span>
            	    	</div>
    				@endif
    				
        			@if($i > 16 && $i < 33)
    	    			{{--*/ continue; /*--}}
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
        		    
            		    <div id="pos{{$i}}" class="@if(!empty($map[$i]) && $map[$i] == 1) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif tire-position-fillable mdl-cell mdl-cell--2-col">
         		    		<div class="@if(strlen($i) > 1) vehicle-map-tire-number @else vehicle-map-tire-number-simple @endif">{{$i}}</div>
         		    	</div>
        		    	
        		    @if($col == 2)
        	    		<div class="mdl-cell mdl-cell--2-col">
        		    		&nbsp;
        		    	</div>
        		    @endif	
        		    	
        		    @if($col == 4)
    	    		</div>
        		    @endif	
        		    
        		@endfor  
    	    	<div class="mdl-color-text--grey tires-back">
    	    		<span>]</span>
    	    	</div>
    	    </div>
    	</div>
</div>

    	<div class="mdl-card__actions">
    		<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
              {{ Lang::get('general.Send') }} 
            </button>
    	</div>