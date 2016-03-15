@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.Types")}}</h1>
@stop

@section('sub-title')
@if ($type->id)
{{--*/ $operation = 'update' /*--}}
{{$type->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newtype")}}
@endif
@stop

@if ($type->id)
@section('breadcrumbs', Breadcrumbs::render('type.edit', $type))
@endif

@section('edit')

@permission($operation.'.type')

@if (!$type->id)
{!! Form::open(array('route' => 'type.store')) !!}
@else
{!! Form::model('$type', [
        'method'=>'PUT',
        'route' => ['type.update',$type->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::select('company_id', $company_id, $type->company_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $type->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('entity_key', Lang::get('general.entity_key'))!!}
        {!!Form::text('entity_key', $type->entity_key, array('class' => 'form-control'))!!}
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