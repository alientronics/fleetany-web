@extends('layouts.default')

@section('title')
<h1>{{Lang::get("general.Vehicles")}}</h1>
@stop

@section('sub-title')
@if ($company->id)
{{--*/ $operation = 'update' /*--}}
{{$company->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newcompany")}}
@endif
@stop

@if ($company->id)
@section('breadcrumbs', Breadcrumbs::render('company.edit', $company))
@endif

@section('content')

@permission($operation.'.company')

@if (!$company->id)
{!! Form::open(array('route' => 'company.store')) !!}
@else
{!! Form::model('$company', [
        'method'=>'PUT',
        'route' => ['company.update',$company->id]
    ]) !!}
@endif

<div class="styleguide mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('contact_id')) is-invalid is-dirty @endif"">
                {!!Form::select('contact_id', $contact_id, $company->contact_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('contact_id', Lang::get('general.contact_id'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('contact_id') }}</span>
            </div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $company->name, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('measure_units')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('measure_units', $company->measure_units, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('measure_units', Lang::get('general.measure_units'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('measure_units') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('api_token')) is-invalid is-dirty @endif" data-upgraded="eP">
         		{!!Form::text('api_token', $company->api_token, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('api_token', Lang::get('general.api_token'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('api_token') }}</span>
			</div>

			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored">
                  Enviar
                </button>
			</div>
		</div>
	</section>
</div>
	
	
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop