@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Vehicle")}}</span>

@stop

@permission('view.vehicle')  

@include('vehicle.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $vehicles,
    	'gridview' => [
    		'pageActive' => 'vehicle',
         	'sortFilters' => [
                ["class" => "mdl-cell--3-col", "name" => "model-vehicle", "lang" => "general.model_vehicle"], 
                ["class" => "mdl-cell--4-col", "name" => "number", "lang" => "general.number"], 
                ["class" => "mdl-cell--3-col", "name" => "cost", "lang" => "general.cost"], 
    		] 
    	]
    ])
	
</div>

@stop   

@endpermission