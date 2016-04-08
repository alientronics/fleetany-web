@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Contact")}}</span>

@stop

@permission('view.contact')

@include('contact.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $contacts,
    	'gridview' => [
    		'pageActive' => 'contact',
         	'sortFilters' => [
                ["class" => "mdl-cell--4-col", "name" => "name", "lang" => "general.name"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "contact-type", "lang" => "general.contact_type"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "city", "lang" => "general.city"], 
    		] 
    	]
    ])
     
</div>

@stop

@endpermission