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
                ["class" => "mdl-cell--2-col", "name" => "vehicle", "lang" => "general.vehicle"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--2-col", "name" => "entry-type", "lang" => "general.entry_type"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--4-col", "name" => "datetime-ini", "lang" => "general.datetime_ini"], 
    			["class" => "mdl-cell--hide-phone mdl-cell--2-col", "name" => "cost", "lang" => "general.cost"], 
    		] 
    	]
    ])
	
</div>

@stop

@endpermission