@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.ModelTire")}}</h1>
@stop

@section('sub-title')
@if ($modeltire->id)
{{$modeltire->name}}
@else
{{Lang::get("general.newmodeltire")}}
@endif
@stop

@if ($modeltire->id)
@section('breadcrumbs', Breadcrumbs::render('modeltire.edit', $modeltire))
@endif

@section('edit')

@role('administrator') 

@if (!$modeltire->id)
{!! Form::open(array('route' => 'modeltire.store')) !!}
@else
{!! Form::model('$modeltire', [
        'method'=>'PUT',
        'route' => ['modeltire.update',$modeltire->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $modeltire->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('pressure_ideal', Lang::get('general.pressure_ideal'))!!}
        {!!Form::text('pressure_ideal', $modeltire->pressure_ideal, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('pressure_max', Lang::get('general.pressure_max'))!!}
        {!!Form::text('pressure_max', $modeltire->pressure_max, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('pressure_min', Lang::get('general.pressure_min'))!!}
        {!!Form::text('pressure_min', $modeltire->pressure_min, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('mileage', Lang::get('general.mileage'))!!}
        {!!Form::text('mileage', $modeltire->mileage, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('temp_ideal', Lang::get('general.temp_ideal'))!!}
        {!!Form::text('temp_ideal', $modeltire->temp_ideal, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('temp_max', Lang::get('general.temp_max'))!!}
        {!!Form::text('temp_max', $modeltire->temp_max, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('temp_min', Lang::get('general.temp_min'))!!}
        {!!Form::text('temp_min', $modeltire->temp_min, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('start_diameter', Lang::get('general.start_diameter'))!!}
        {!!Form::text('start_diameter', $modeltire->start_diameter, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('start_depth', Lang::get('general.start_depth'))!!}
        {!!Form::text('start_depth', $modeltire->start_depth, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('type_land', Lang::get('general.type_land'))!!}
        {!!Form::text('type_land', $modeltire->type_land, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endrole

@stop