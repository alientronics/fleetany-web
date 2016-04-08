@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.User")}}</span>

@stop

@permission('view.user') 

@include('user.filter')

@section('content')

<div class="mdl-grid demo-content">

	@include('includes.gridview', [
    	'registers' => $users,
    	'gridview' => [
    		'pageActive' => 'user',
         	'sortFilters' => [
                ["class" => "mdl-cell--3-col", "name" => "name", "lang" => "general.name"], 
                ["class" => "hideme-mobile mdl-cell--3-col", "name" => "email", "lang" => "general.email"],  
                ["class" => "hideme-mobile mdl-cell--2-col", "name" => "contact-id", "lang" => "general.contact_id"],  
                ["class" => "hideme-mobile mdl-cell--2-col", "name" => "company-id", "lang" => "general.company_id"], 
    		] 
    	]
    ])

</div>

@stop

@endpermission