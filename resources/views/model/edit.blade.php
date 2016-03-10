@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Models")}}</h1>
@stop

@section('sub-title')
@if ($model->id)
{{--*/ $operation = 'update' /*--}}
{{$model->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newmodel")}}
@endif
@stop

@if ($model->id)
@section('breadcrumbs', Breadcrumbs::render('model.edit', $model))
@endif

@section('edit')

@permission($operation.'.model')

@if (!$model->id)
{!! Form::open(array('route' => 'model.store')) !!}
@else
{!! Form::model('$model', [
        'method'=>'PUT',
        'route' => ['model.update',$model->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $company_id, $model->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('model_type_id', Lang::get('general.model_type_id'))!!}
        {!!Form::select('model_type_id', $model_type_id, $model->model_type_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('vendor_id', Lang::get('general.vendor_id'))!!}
        {!!Form::select('vendor_id', $vendor_id, $model->vendor_id, array('class' => 'form-control'))!!}
    </div>
    
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $model->name, array('class' => 'form-control'))!!}
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