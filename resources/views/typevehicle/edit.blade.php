@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.TypeVehicle")}}</h1>
@stop

@section('sub-title')
@if ($typevehicle->id)
{{$typevehicle->name}}
@else
{{Lang::get("general.newtypevehicle")}}
@endif
@stop

@section('breadcrumbs', Breadcrumbs::render('typevehicle.edit', $typevehicle))

@section('edit')

@if (!$typevehicle->id)
{!! Form::open(array('route' => 'typevehicle.store')) !!}
@else
{!! Form::model('$typevehicle', [
        'method'=>'PUT',
        'route' => ['typevehicle.update',$typevehicle->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $typevehicle->name, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@stop