@extends('layouts.default')

@section('header')
	@if ($company->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$company->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Company")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.company')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$company->id)
{!! Form::open(['route' => 'company.store']) !!}
@else
{!! Form::model('$company', [
        'method'=>'PUT',
        'route' => ['company.update',$company->id]
    ]) !!}
@endif

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $company->name, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>

			@include ('contact.shared-fields')
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('measure_units')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('measure_units', $company->measure_units, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('measure_units', Lang::get('general.measure_units'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('measure_units') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('api_token')) is-invalid is-dirty @endif" data-upgraded="eP">
         		{!!Form::text('api_token', $company->api_token, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('api_token', Lang::get('general.api_token'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('api_token') }}</span>
			</div>

			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
                  {{ Lang::get('general.Send') }} 
                </button>
			</div>
	
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