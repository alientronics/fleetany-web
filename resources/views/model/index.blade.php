@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Model")}}</span>

@stop

@permission('view.model')  

@include('model.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $models,
    	'gridview' => [
    		'pageActive' => 'model',
         	'sortFilters' => [
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--4-col", "name" => "vendor", "lang" => "general.vendor"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--4-col", "name" => "model-type", "lang" => "general.model_type"], 
                ["class" => "mdl-cell--2-col", "name" => "name", "lang" => "general.name"], 
    		] 
    	]
    ])
     
</div>

@stop    
	
@endpermission	  