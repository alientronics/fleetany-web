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
@else
{!! Form::model('$contact', [
        'method'=>'PUT',
        'route' => ['contact.update',$contact->id]
    ]) !!}
@endif

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('contact_type_id')) is-invalid is-dirty @endif"">
                {!!Form::select('contact_type_id', $contact_type_id, $contact->contact_type_id, ['class' => 'mdl-textfield__input'])!!}
       			{!!Form::label('contact_type_id', Lang::get('general.contact_type'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
            	<span class="mdl-textfield__error">{{ $errors->first('contact_type_id') }}</span>
            </div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $contact->name, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>
			
			@include ('contact.shared-fields')

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