@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Vehicles")}}</h1>
@stop

@section('sub-title')
@if ($vehicle->id)
{{--*/ $operation = 'update' /*--}}
{{$vehicle->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newvehicle")}}
@endif
@stop

@if ($vehicle->id)
@section('breadcrumbs', Breadcrumbs::render('vehicle.edit', $vehicle))
@endif

@section('edit')

@permission($operation.'.vehicle')

@if (!$vehicle->id)
{!! Form::open(array('route' => 'vehicle.store')) !!}
@else
{!! Form::model('$vehicle', [
        'method'=>'PUT',
        'route' => ['vehicle.update',$vehicle->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $role, $vehicle->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('model_vehicle_id', Lang::get('general.model_vehicle_id'))!!}
        {!!Form::select('model_vehicle_id', $model_vehicle_id, $vehicle->model_vehicle_id, array('class' => 'form-control'))!!}
    </div>
    
    <div class="form-group col-lg-12">
        {!!Form::label('number', Lang::get('general.number'))!!}
        {!!Form::text('number', $vehicle->number, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('initial_miliage', Lang::get('general.initial_miliage'))!!}
        {!!Form::text('initial_miliage', $vehicle->initial_miliage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('actual_miliage', Lang::get('general.actual_miliage'))!!}
        {!!Form::text('actual_miliage', $vehicle->actual_miliage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('cost', Lang::get('general.cost'))!!}
        {!!Form::text('cost', $vehicle->cost, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('description', Lang::get('general.description'))!!}
        {!!Form::text('description', $vehicle->description, array('class' => 'form-control'))!!}
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