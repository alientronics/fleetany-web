@extends('layouts.default')
@extends('layouts.edit')

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

@section('edit')

@permission($operation.'.company')

@if (!$company->id)
{!! Form::open(array('route' => 'company.store')) !!}
@else
{!! Form::model('$company', [
        'method'=>'PUT',
        'route' => ['company.update',$company->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('contact_id', Lang::get('general.contact_id'))!!}
        {!!Form::select('contact_id', $contact_id, $company->contact_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $company->name, array('class' => 'form-control'))!!}
    </div>
    
    <div class="form-group col-lg-12">
        {!!Form::label('measure_units', Lang::get('general.measure_units'))!!}
        {!!Form::text('measure_units', $company->measure_units, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('api_token', Lang::get('general.api_token'))!!}
        {!!Form::text('api_token', $company->api_token, array('class' => 'form-control'))!!}
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