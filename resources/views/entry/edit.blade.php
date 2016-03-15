@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Entries")}}</h1>
@stop

@section('sub-title')
@if ($entry->id)
{{--*/ $operation = 'update' /*--}}
{{$entry->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newentry")}}
@endif
@stop

@if ($entry->id)
@section('breadcrumbs', Breadcrumbs::render('entry.edit', $entry))
@endif

@section('edit')

@permission($operation.'.entry')

@if (!$entry->id)
{!! Form::open(array('route' => 'entry.store')) !!}
@else
{!! Form::model('$entry', [
        'method'=>'PUT',
        'route' => ['entry.update',$entry->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $company_id, $entry->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('entry_type_id', Lang::get('general.entry_type'))!!}
        {!!Form::select('entry_type_id', $entry_type_id, $entry->entry_type_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('vendor_id', Lang::get('general.vendor'))!!}
        {!!Form::select('vendor_id', $vendor_id, $entry->vendor_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('vehicle_id', Lang::get('general.vehicle'))!!}
        {!!Form::select('vehicle_id', $vehicle_id, $entry->vehicle_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('datetime_ini', Lang::get('general.datetime_ini'))!!}
        {!!Form::text('datetime_ini', $entry->datetime_ini, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('datetime_end', Lang::get('general.datetime_end'))!!}
        {!!Form::text('datetime_end', $entry->datetime_end, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('entry_number', Lang::get('general.entry_number'))!!}
        {!!Form::text('entry_number', $entry->entry_number, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('cost', Lang::get('general.cost'))!!}
        {!!Form::text('cost', $entry->cost, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('description', Lang::get('general.description'))!!}
        {!!Form::text('description', $entry->description, array('class' => 'form-control'))!!}
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