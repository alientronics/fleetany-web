@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Type")}}</span>

@stop

@include('type.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $types,
    	'gridview' => [
    		'pageActive' => 'type',
         	'sortFilters' => [
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--8-col", "name" => "entity-key", "lang" => "general.entity_key"], 
                ["class" => "mdl-cell--2-col", "name" => "name", "lang" => "general.name"], 
    		] 
    	]
    ])
     
</div>

@stop