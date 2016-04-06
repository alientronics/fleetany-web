@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Company")}}</span>

@stop

@permission('view.company') 

@include('company.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $companies,
    	'gridview' => [
    		'pageActive' => 'company',
         	'sortFilters' => [
                ["class" => "mdl-cell--4-col", "name" => "name", "lang" => "general.name"], 
                ["class" => "mdl-cell--3-col", "name" => "city", "lang" => "general.city"], 
                ["class" => "mdl-cell--3-col", "name" => "country", "lang" => "general.country"], 
    		] 
    	]
    ])
    
</div>

@stop

@endpermission