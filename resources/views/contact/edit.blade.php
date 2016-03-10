@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Contacts")}}</h1>
@stop

@section('sub-title')
@if ($contact->id)
{{--*/ $operation = 'update' /*--}}
{{$contact->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newcontact")}}
@endif
@stop

@if ($contact->id)
@section('breadcrumbs', Breadcrumbs::render('contact.edit', $contact))
@endif

@section('edit')

@permission($operation.'.contact')

@if (!$contact->id)
{!! Form::open(array('route' => 'contact.store')) !!}
@else
{!! Form::model('$contact', [
        'method'=>'PUT',
        'route' => ['contact.update',$contact->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $company_id, $contact->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('contact_type_id', Lang::get('general.contact_type_id'))!!}
        {!!Form::select('contact_type_id', $contact_type_id, $contact->contact_type_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $contact->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('country', Lang::get('general.country'))!!}
        {!!Form::text('country', $contact->country, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('state', Lang::get('general.state'))!!}
        {!!Form::text('state', $contact->state, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('city', Lang::get('general.city'))!!}
        {!!Form::text('city', $contact->city, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('address', Lang::get('general.address'))!!}
        {!!Form::text('address', $contact->address, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('phone', Lang::get('general.phone'))!!}
        {!!Form::text('phone', $contact->phone, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('license_no', Lang::get('general.license_no'))!!}
        {!!Form::text('license_no', $contact->license_no, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop