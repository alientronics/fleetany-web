@extends('layouts.default')

@section('header')
	<span class="mdl-layout-title">{{$vehicle->model->name}} - {{$vehicle->number}}</span>
@stop

@section('content')

<div id="vehicle-dashboard" class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.Current", "view" => "vehicle.showtabs.current"]; /*--}}

@if (class_exists('Alientronics\FleetanyWebReports\Controllers\ReportController'))
{{--*/ $tabs[] = ["title" => "general.History", "view" => "fleetany-web-reports::reports.vehicles.history-chart"]; /*--}}
@endif

@include('includes.tabs', [
	'tabs' => $tabs
])

		</div>
	</section>
</div>

@stop
