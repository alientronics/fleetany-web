@extends('layouts.default')

@section('header')
	@if ($vehicle->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$vehicle->model->name}}</span>
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

      		<div id="last-position" style="display: none">
      			<b>{{ Lang::get('general.LastPosition') }}: </b>
    		</div>
  		
@if (!$vehicle->id)
{!! Form::open(['route' => 'vehicle.store']) !!}
@else
{!! Form::model('$vehicle', [
        'method'=>'PUT',
        'route' => ['vehicle.update',$vehicle->id]
    ]) !!}
@endif
            
	@include('includes.tabs', [
    	'tabs' => [
            ["title" => "general.VehicleData", "view" => "vehicle.tabs.vehicledata"], 
            ["title" => "general.Parts", "view" => "vehicle.tabs.showparts"], 
    	]
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
                		$("#last-position").html($("#last-position").html() + results[0].formatted_address);
                		$("#last-position").show();
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