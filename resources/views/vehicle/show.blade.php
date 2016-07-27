@extends('layouts.default')

@section('header')
	<span class="mdl-layout-title">{{$vehicle->model->name}} - {{$vehicle->number}}</span>
@stop

@section('content')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

            <div class="mdl-grid demo-content">
            
				<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
            	<input type="hidden" name="tire-position-focus-id" id="tire-position-focus-id" />
            	
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
                    		    
                    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) @if(!empty($tiresPositions[$key + 1])) mdl-color--green @else mdl-color--grey @endif @endif tires-show mdl-cell mdl-cell--2-col">
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
            		        {{Lang::get('general.VehicleAndLocalizationData')}}
            			</div>
            			
            			<div class="mdl-card__actions mdl-card--border"></div>
            		    <div id="vehicle-detail">
            		    	<div id="vehicle-detail-data">
            		    	{{Lang::get('general.model_vehicle')}}: {{$vehicle->model->name}}<br/>
            		    	{{Lang::get('general.number')}}:  {{$vehicle->number}}<br/>
            		    	<div id="vehicle-detail-refresh-data">
                		    @if(!empty($localizationData))
                		    	{{Lang::get('general.latitude')}}:  {{$localizationData->latitude}}<br/>
                		    	{{Lang::get('general.longitude')}}:  {{$localizationData->longitude}}<br/>
                		    	{{Lang::get('general.speed')}}:  {{$localizationData->speed}}<br/>
            		    	@endif	
            		    	</div>
            		    	</div>
            		    </div>
            		</div>
            
            		<div class="mdl-cell--1-col" style="height: 32px;"></div>
            
            		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            			<div class="mdl-button mdl-button--colored">
            		        {{Lang::get('general.SelectedTireAndSensorData')}}
            			</div>
            			
            			<div class="mdl-card__actions mdl-card--border"></div>
            		    <div id="tire-detail">
            		    	<div id="tire-detail-data"></div>
            		    </div>
            		</div>
            		
            		<div class="mdl-cell--1-col" style="height: 32px;"></div>
            
            		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            			<div class="mdl-button mdl-button--colored">
            		        {{Lang::get('general.DriverData')}}
            			</div>
            			
            			<div class="mdl-card__actions mdl-card--border"></div>
            		    <div id="driver-detail">
            		    	<div id="driver-detail-data">
            		    	{{Lang::get('general.name')}}: @if(!empty($driverData->name)) {{$driverData->name}} @endif<br/>
            		    	{{Lang::get('general.phone')}}: @if(!empty($driverData->phone)) {{$driverData->phone}} @endif <br/>
            		    	</div>
            		    </div>
            		</div>
            	</div>
            </div>

		</div>
	</section>
</div>

@stop







