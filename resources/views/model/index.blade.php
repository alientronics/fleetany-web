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
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "vendor", "lang" => "general.vendor"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "model-type", "lang" => "general.model_type"], 
                ["class" => "mdl-cell--4-col", "name" => "name", "lang" => "general.name"], 
    		] 
    	]
    ])
     
</div>

@stop    
	
@endpermission	  