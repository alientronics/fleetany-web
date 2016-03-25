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
{!! Form::open(array('route' => 'contact.store')) !!}
@else
{!! Form::model('$contact', [
        'method'=>'PUT',
        'route' => ['contact.update',$contact->id]
    ]) !!}
@endif

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('company_id')) is-invalid is-dirty @endif"">
                {!!Form::select('company_id', $company_id, $contact->company_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('company_id', Lang::get('general.company_id'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('company_id') }}</span>
            </div>

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('contact_type_id')) is-invalid is-dirty @endif"">
                {!!Form::select('contact_type_id', $contact_type_id, $contact->contact_type_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('contact_type_id', Lang::get('general.contact_type'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('contact_type_id') }}</span>
            </div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $contact->name, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('country')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('country', $contact->country, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('country', Lang::get('general.country'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('country') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('state')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('state', $contact->state, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('state', Lang::get('general.state'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('state') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('city')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('city', $contact->city, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('city', Lang::get('general.city'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('city') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('address')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('address', $contact->address, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('address', Lang::get('general.address'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('address') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('phone')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('phone', $contact->phone, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('phone', Lang::get('general.phone'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('phone') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('license_no')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('license_no', $contact->license_no, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('license_no', Lang::get('general.license_no'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('license_no') }}</span>
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