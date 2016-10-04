<div class="mdl-grid demo-content">

	<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
	<input type="hidden" name="tire-position-focus-id" id="tire-position-focus-id" />
	
    @include('fleet.map', [
    	'pageActive' => 'vehicleShow',
    	'vehicle' => $vehicle,
    	'modelMap' => $vehicle->model->map,
    	'tireData' => $fleetData['tireData'][$vehicle->id]
    ])

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