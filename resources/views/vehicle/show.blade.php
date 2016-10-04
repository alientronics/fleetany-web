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
{{--*/ $tabs[] = ["title" => "general.History", "view" => "vehicle.showtabs.history"]; /*--}}

@include('includes.tabs', [
	'tabs' => $tabs
])

		</div>
	</section>
</div>

@stop
