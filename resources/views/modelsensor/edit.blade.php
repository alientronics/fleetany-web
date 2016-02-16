@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.ModelSensor")}}</h1>
@stop

@section('sub-title')
@if ($modelsensor->id)
{{$modelsensor->name}}
@else
{{Lang::get("general.newmodelsensor")}}
@endif
@stop

@if ($modelsensor->id)
@section('breadcrumbs', Breadcrumbs::render('modelsensor.edit', $modelsensor))
@endif

@section('edit')

@if (!$modelsensor->id)
{!! Form::open(array('route' => 'modelsensor.store')) !!}
@else
{!! Form::model('$modelsensor', [
        'method'=>'PUT',
        'route' => ['modelsensor.update',$modelsensor->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $modelsensor->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('version', Lang::get('general.Version'))!!}
        {!!Form::text('version', $modelsensor->version, array('class' => 'form-control'))!!}
    </div>


    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@stop