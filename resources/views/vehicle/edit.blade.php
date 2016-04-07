@extends('layouts.default')

@section('header')
	@if ($vehicle->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$vehicle->model->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Vehicle")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.vehicle')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$vehicle->id)
{!! Form::open(array('route' => 'vehicle.store')) !!}
@else
{!! Form::model('$vehicle', [
        'method'=>'PUT',
        'route' => ['vehicle.update',$vehicle->id]
    ]) !!}
@endif
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('model_vehicle_id')) is-invalid is-dirty @endif"">
                {!!Form::select('model_vehicle_id', $model_vehicle_id, $vehicle->model_vehicle_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('model_vehicle_id', Lang::get('general.model_vehicle'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('model_vehicle_id') }}</span>
            </div>
            
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('number', $vehicle->number, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('number', Lang::get('general.number'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
			</div>    
            
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('initial_miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('initial_miliage', $vehicle->initial_miliage, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('initial_miliage', Lang::get('general.initial_miliage'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('initial_miliage') }}</span>
			</div>  
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('actual_miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('actual_miliage', $vehicle->actual_miliage, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('actual_miliage', Lang::get('general.actual_miliage'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('actual_miliage') }}</span>
			</div>  
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('cost', $vehicle->cost, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('cost', Lang::get('general.cost'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('cost') }}</span>
			</div>  
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('description')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('description', $vehicle->description, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('description', Lang::get('general.description'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('description') }}</span>
			</div>  			

			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored">
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