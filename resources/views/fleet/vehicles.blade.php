<div id="fleet-dashboard-vehicles">
    @foreach($vehicles as $index => $vehicle)
        @if($index % 2 == 0) 
        <div class="mdl-grid demo-content">
        @endif
        
            @include('fleet.map', [
            	'pageActive' => 'fleet',
            	'vehicle' => $vehicle,
            	'tireData' => $tireData[$vehicle->id],
            	'gpsData' => $gpsData[$vehicle->id],
            	'modelMap' => $modelMaps[$vehicle->model_vehicle_id]
            ])
            

        @if($index % 2 > 0) 
        </div>
        @endif
        
    @endforeach
</div>
