@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.ModelMonitor")}}</h1>
@stop

@section('sub-title')
@if ($modelmonitor->id)
{{$modelmonitor->name}}
@else
{{Lang::get("general.newmodelmonitor")}}
@endif
@stop

@if ($modelmonitor->id)
@section('breadcrumbs', Breadcrumbs::render('modelmonitor.edit', $modelmonitor))
@endif

@section('edit')

@role('administrator') 

@if (!$modelmonitor->id)
{!! Form::open(array('route' => 'modelmonitor.store')) !!}
@else
{!! Form::model('$modelmonitor', [
        'method'=>'PUT',
        'route' => ['modelmonitor.update',$modelmonitor->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $modelmonitor->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('version', Lang::get('general.Version'))!!}
        {!!Form::text('version', $modelmonitor->version, array('class' => 'form-control'))!!}
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