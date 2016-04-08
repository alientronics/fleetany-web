@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Type")}}</span>

@stop

@permission('view.type')  

@include('type.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $types,
    	'gridview' => [
    		'pageActive' => 'type',
         	'sortFilters' => [
                ["class" => "hideme-mobile mdl-cell--5-col", "name" => "entity-key", "lang" => "general.entity_key"], 
                ["class" => "mdl-cell--5-col", "name" => "name", "lang" => "general.name"], 
    		] 
    	]
    ])
     
</div>

@stop

@endpermission