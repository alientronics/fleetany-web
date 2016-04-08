@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Trip")}}</span>

@stop

@permission('view.trip')  

@include('trip.filter')

@section('content')

<div class="mdl-grid demo-content">

    @include('includes.gridview', [
    	'registers' => $trips,
    	'gridview' => [
    		'pageActive' => 'trip',
         	'sortFilters' => [
                ["class" => "mdl-cell--3-col", "name" => "vehicle", "lang" => "general.vehicle"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "trip-type", "lang" => "general.trip_type"], 
                ["class" => "hideme-mobile mdl-cell--2-col", "name" => "pickup-date", "lang" => "general.pickup_date"], 
                ["class" => "hideme-mobile mdl-cell--2-col", "name" => "fuel-cost", "lang" => "general.fuel_cost"],
    		] 
    	]
    ])
        
</div>

@stop

@endpermission