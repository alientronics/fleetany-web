@extends('layouts.default')

@section('header')
	@if ($vehicle->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.fleet_number")}}: {{$vehicle->fleet}} - {{Lang::get("general.number")}}: {{$vehicle->number}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Vehicle")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.vehicle')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.VehicleData", "view" => "vehicle.tabs.vehicledata"]; /*--}}

@if (config('app.attributes_api_url') != null
		&& !empty($attributes))
	{{--*/ $tabs[] = ["title" => "attributes.Attributes", "view" => "includes.attributes", 'attributes' => $attributes]; /*--}}
@endif
@if (class_exists('Alientronics\FleetanyWebGeofence\FleetanyWebGeofenceServiceProvider'))
    {{--*/ $tabs[] = ["title" => "geofence.Geofence", "view" => "vehicle.tabs.geofence"]; /*--}}
@endif

@if (!$vehicle->id)
{!! Form::open(['route' => 'vehicle.store', 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::model('$vehicle', [
        'method'=>'PUT',
        'route' => ['vehicle.update',$vehicle->id]
    ]) !!}
    
    {{--*/ $tabs[] = ["title" => "general.Tires", "view" => "vehicle.tabs.tires"]; /*--}}
    {{--*/ $tabs[] = ["title" => "general.Parts", "view" => "vehicle.tabs.showparts"]; /*--}}  
@endif
         
@include('includes.tabs', [
	'tabs' => $tabs
])
           
{!! Form::close() !!}
			
		</div>
	</section>
</div>

<script>
	$( document ).ready(function() {
		$('#cost').maskMoney({!!Lang::get("masks.money")!!});

		@if(!empty($vehicleLastPlace))

		   var geocoder = new google.maps.Geocoder();
		   if (geocoder) {
		   	  var latLng = new google.maps.LatLng({{$vehicleLastPlace->latitude}}, {{$vehicleLastPlace->longitude}});
		      geocoder.geocode({'location': latLng}, function (results, status) {
		         if (status == google.maps.GeocoderStatus.OK) {
            		if(results[0] != undefined) {
                		$("#last_position").val(results[0].formatted_address);
                		$("#div_last_position").show();
                	}
		         }
		         else {
		            console.log("Geocoding failed: " + status);
		         }
		      });
		   }    
		
		@endif
		
	});
</script>
@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop