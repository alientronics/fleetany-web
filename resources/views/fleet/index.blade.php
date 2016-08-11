@extends('layouts.default')

@section('header')
	<span class="mdl-layout-title">{{Lang::get("general.Fleet")}}</span>
@stop

@section('content')

<div id="fleet-dashboard" class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

			@include('fleet.vehicles', [
            	'vehicles' => $vehicles,
            	'tireData' => $tireData,
            	'modelMaps' => $modelMaps
            ])
                
		</div>
	</section>
</div>

@stop


