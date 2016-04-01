@extends('layouts.default')

@section('header')
	@if ($type->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$type->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Type")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.type')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$type->id)
{!! Form::open(array('route' => 'type.store')) !!}
@else
{!! Form::model('$type', [
        'method'=>'PUT',
        'route' => ['type.update',$type->id]
    ]) !!}
@endif
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $type->name, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('entity_key')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('entity_key', $type->entity_key, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('entity_key', Lang::get('general.entity_key'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('entity_key') }}</span>
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
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop