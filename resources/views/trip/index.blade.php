@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Trip")}}</span>

@stop

@include('trip.filter')

@section('content')

<div class="mdl-grid demo-content">

    @include('includes.gridview', [
    	'registers' => $trips,
    	'gridview' => [
    		'pageActive' => 'trip',
         	'sortFilters' => [
                ["class" => "mdl-cell--2-col", "name" => "vehicle", "lang" => "general.vehicle"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--4-col", "name" => "trip-type", "lang" => "general.trip_type"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--2-col", "name" => "pickup-date", "lang" => "general.pickup_date", "mask" => "datetime"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--2-col", "name" => "fuel-cost", "lang" => "general.fuel_cost", "mask" => "money"],
    		] 
    	]
    ])
        
</div>

@stop