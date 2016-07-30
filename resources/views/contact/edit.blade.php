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
		
		
{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.ContactData", "view" => "contact.tabs.contactdata"]; /*--}}
@if (config('app.attributes_api_url') != null
		&& !empty($attributes))
	{{--*/ $tabs[] = ["title" => "attributes.Attributes", "view" => "includes.attributes", 'attributes' => $attributes]; /*--}}
@endif

@if (!$contact->id)
{!! Form::open(['route' => 'contact.store', 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::model('$contact', [
        'method'=>'PUT',
        'enctype' => 'multipart/form-data',
        'route' => ['contact.update',$contact->id]
    ]) !!}
    
    @if (!empty($driver_profile->toArray()) && class_exists('Alientronics\FleetanyWebDriver\FleetanyWebDriverServiceProvider'))
        {{--*/ $tabs[] = ["title" => "general.DriverProfile", "view" => "contact.tabs.driverprofile"]; /*--}}
    @endif
@endif

@include('includes.tabs', [
	'tabs' => $tabs
])
	
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