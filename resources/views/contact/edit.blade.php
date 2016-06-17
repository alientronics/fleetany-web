@extends('layouts.default')

@section('header')
	@if ($contact->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$contact->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Contact")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.contact')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">
		
@if (!$contact->id)
{!! Form::open(['route' => 'contact.store']) !!}

    	@include('includes.tabs', [
        	'tabs' => [
                ["title" => "general.ContactData", "view" => "contact.tabs.contactdata"], 
        	]
        ])
        
@else
{!! Form::model('$contact', [
        'method'=>'PUT',
        'route' => ['contact.update',$contact->id]
    ]) !!}
    
    
    @if (!empty($driver_profile) && class_exists('Alientronics\FleetanyWebDriver\FleetanyWebDriverServiceProvider'))
        @include('includes.tabs', [
        	'tabs' => [
                ["title" => "general.ContactData", "view" => "contact.tabs.contactdata"], 
                ["title" => "general.DriverProfile", "view" => "contact.tabs.driverprofile"], 
        	]
        ])
    @else
    	@include('includes.tabs', [
        	'tabs' => [
                ["title" => "general.ContactData", "view" => "contact.tabs.contactdata"], 
        	]
        ])
    @endif
@endif

	
{!! Form::close() !!}

		</div>
	</section>
</div>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop