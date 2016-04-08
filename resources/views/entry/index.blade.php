@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Entry")}}</span>

@stop

@permission('view.entry')

@include('entry.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $entries,
    	'gridview' => [
    		'pageActive' => 'entry',
         	'sortFilters' => [
                ["class" => "mdl-cell--3-col", "name" => "vehicle", "lang" => "general.vehicle"], 
                ["class" => "hideme-mobile mdl-cell--2-col", "name" => "entry-type", "lang" => "general.entry_type"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "datetime-ini", "lang" => "general.datetime_ini"], 
    			["class" => "hideme-mobile mdl-cell--2-col", "name" => "cost", "lang" => "general.cost"], 
    		] 
    	]
    ])
	
</div>

@stop

@endpermission