@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.City")}}</h1>
@stop

@section('sub-title')
@if ($city->id)
{{$city->name}}
@else
{{Lang::get("general.newcity")}}
@endif
@stop

@section('breadcrumbs', Breadcrumbs::render('city.edit', $city))

@section('edit')

@if (!$city->id)
{!! Form::open(array('route' => 'city.store')) !!}
@else
{!! Form::model('$city', [
        'method'=>'PUT',
        'route' => ['city.update',$city->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $city->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-6">
        {!!Form::label('state_id', Lang::get('general.State'))!!}
        {!!Form::select('state_id', $states, $city->state_id,
            array('class'=>'form-control')
        )!!}
    </div>


    <div class="form-group col-lg-6">
        {!!Form::label('country_id', Lang::get('general.Country'))!!}
        {!!Form::select('country_id', $countries, $city->country_id,
            array('class'=>'form-control')
        )!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@stop