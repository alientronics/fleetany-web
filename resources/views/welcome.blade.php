@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get('menu.FleetPanel')}}</span>

@stop

@section('content')

<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
</script>

<div class="mdl-grid demo-content">

    <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid mdl-color--primary">
    	<div class="mdl-card__actions mdl-color--primary">
    		<div id="map"></div>
    	</div>
    </div>
    	
		@include ('includes.statistics.cardnumber', ['statistics' => $vehiclesStatistics,
										'cardTitle' => Lang::get('general.Vehicles'),
										'cardLink' => url('/').'/vehicle'
		])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $servicesStatistics,
										'cardTitle' => Lang::get('general.Services'),
										'cardLink' => url('/').'/entry'
		])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $tripsStatistics,
										'cardTitle' => Lang::get('general.Trips'),
										'cardLink' => url('/').'/trip'
		])
		
		@include ('includes.statistics.cardbarchart', ['statistics' => $lastsFuelCostStatistics, 
														'x_desc' => 'Mes',
														'y_desc' => 'Custo',
														'name' => 'fuel_cost',
														'cardTitle' => Lang::get('general.FuelCost'),
														'cardLink' => url('/').'/trip'
		])

		@include ('includes.statistics.cardbarchart', ['statistics' => $lastsServiceCostStatistics, 
														'x_desc' => 'Mes',
														'y_desc' => 'Custo',
														'name' => 'service_cost',
														'cardTitle' => Lang::get('general.ServiceCost'),
														'cardLink' => url('/').'/entry'  
		])
		
</div>

<script type="text/javascript">
    function initMap() {

        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: {lat: -30.02, lng: -51.11}
        });

        @foreach($vehiclesLastPlace as $vehicle)
            var myLatLng = {lat: {{$vehicle->latitude}}, lng: {{$vehicle->longitude}}};
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });

            @if($vehicle['in_geofence'] == true)
            marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png')
            @endif

            marker.addListener('click', function() {
            	window.location.href = "{{url('/')}}/vehicle/{{$vehicle->vehicle_id}}/edit";
          	});
            
            var latlng = new google.maps.LatLng({{$vehicle->latitude}}, {{$vehicle->longitude}});
            bounds.extend(latlng); 
    	@endforeach

        @if(count($vehiclesLastPlace) > 0)	    
        	map.fitBounds(bounds);
        @endif

    }
</script>
@endsection
