@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Trips")}}</h1>
@stop

@section('sub-title')
@if ($trip->id)
{{--*/ $operation = 'update' /*--}}
{{$trip->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newtrip")}}
@endif
@stop

@if ($trip->id)
@section('breadcrumbs', Breadcrumbs::render('trip.edit', $trip))
@endif

@section('edit')

@permission($operation.'.trip')

@if (!$trip->id)
{!! Form::open(array('route' => 'trip.store')) !!}
@else
{!! Form::model('$trip', [
        'method'=>'PUT',
        'route' => ['trip.update',$trip->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $company_id, $trip->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('driver_id', Lang::get('general.driver_id'))!!}
        {!!Form::select('driver_id', $driver_id, $trip->driver_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('vehicle_id', Lang::get('general.vehicle_id'))!!}
        {!!Form::select('vehicle_id', $vehicle_id, $trip->vehicle_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('vendor_id', Lang::get('general.vendor_id'))!!}
        {!!Form::select('vendor_id', $vendor_id, $trip->vendor_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('trip_type_id', Lang::get('general.trip_type_id'))!!}
        {!!Form::select('trip_type_id', $trip_type_id, $trip->trip_type_id, array('class' => 'form-control'))!!}
    </div>
    
    <div class="form-group col-lg-12">
        {!!Form::label('pickup_date', Lang::get('general.pickup_date'))!!}
        {!!Form::text('pickup_date', $trip->pickup_date, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('deliver_date', Lang::get('general.deliver_date'))!!}
        {!!Form::text('deliver_date', $trip->deliver_date, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('pickup_place', Lang::get('general.pickup_place'))!!}
        {!!Form::text('pickup_place', $trip->pickup_place, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('deliver_place', Lang::get('general.deliver_place'))!!}
        {!!Form::text('deliver_place', $trip->deliver_place, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('begin_mileage', Lang::get('general.begin_mileage'))!!}
        {!!Form::text('begin_mileage', $trip->begin_mileage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('end_mileage', Lang::get('general.end_mileage'))!!}
        {!!Form::text('end_mileage', $trip->end_mileage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('total_mileage', Lang::get('general.total_mileage'))!!}
        {!!Form::text('total_mileage', $trip->total_mileage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('fuel_cost', Lang::get('general.fuel_cost'))!!}
        {!!Form::text('fuel_cost', $trip->fuel_cost, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('fuel_amount', Lang::get('general.fuel_amount'))!!}
        {!!Form::text('fuel_amount', $trip->fuel_amount, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('description', Lang::get('general.description'))!!}
        {!!Form::text('description', $trip->description, array('class' => 'form-control'))!!}
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