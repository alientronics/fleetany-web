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
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('limit_temperature')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('limit_temperature', $company->limit_temperature, ['id' => 'limit_temperature', 'class' => 'mdl-textfield__input'])!!}
				{!!Form::label('limit_temperature', Lang::get('general.limit_temperature'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('limit_temperature') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('ideal_pressure')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('ideal_pressure', $company->ideal_pressure, ['id' => 'ideal_pressure', 'class' => 'mdl-textfield__input'])!!}
				{!!Form::label('ideal_pressure', Lang::get('general.ideal_pressure'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('ideal_pressure') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('delta_pressure')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('delta_pressure', $company->delta_pressure, ['id' => 'delta_pressure', 'class' => 'mdl-textfield__input'])!!}
				{!!Form::label('delta_pressure', Lang::get('general.delta_pressure'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('delta_pressure') }}</span>
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


<script>
	$( document ).ready(function() {
		$('#limit_temperature').maskMoney({!!Lang::get("masks.money")!!});
		$('#ideal_pressure').maskMoney({!!Lang::get("masks.money")!!});
		$('#delta_pressure').maskMoney({!!Lang::get("masks.percent")!!});
	});
</script>
@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop