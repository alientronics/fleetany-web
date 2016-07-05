@extends('layouts.default')

@section('header')
	@if ($model->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$model->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Model")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.model')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$model->id)
{!! Form::open(['route' => 'model.store']) !!}
@else
{!! Form::model('$model', [
        'method'=>'PUT',
        'route' => ['model.update',$model->id]
    ]) !!}
@endif

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.ModelData", "view" => "model.tabs.modeldata"]; /*--}}

@if (!empty($model->type->entity_key) && $model->type->entity_key == 'vehicle')
    {{--*/ $tabs[] = ["title" => "general.VehicleMap", "view" => "model.tabs.map"]; /*--}}
@endif

@include('includes.tabs', [
	'tabs' => $tabs
])
	
{!! Form::close() !!}

		</div>
	</section>
</div>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop