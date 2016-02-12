@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelSensors")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelsensor'))

@section('actions')
{!!Form::actions(array('new' => route("modelsensor.create")))!!}
@stop

@section('table')
@if (count($modelsensors) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.Version")}}</th>
            <th>{{Lang::get("general.Actions")}}</th>
        </tr>
    </thead>
    @foreach($modelsensors as $modelsensor) 
        <tr>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->id}}</a></td>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->name}}</a></td>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->version}}</a></td>
            <td>
                {!!Form::delete(route('modelsensor.destroy',$modelsensor->id))!!}
            </td>
        </tr>
    @endforeach
</table>


@else
<div class="alert alert-info">
    {{Lang::get("general.norecordsfound")}}
</div>
@endif
                           
@stop

@section("script")

@stop