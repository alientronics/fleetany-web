<div id="fleet-dashboard-vehicles">
    @foreach($vehicles as $index => $vehicle)
        @if($index % 2 == 0) 
        <div class="mdl-grid demo-content">
        @endif
        
            @include('fleet.map', [
            	'vehicle' => $vehicle,
            	'tireData' => $tireData[$vehicle->id]
            ])
            
        @if($index % 2 > 0) 
        </div>
        @endif
    @endforeach
</div>
