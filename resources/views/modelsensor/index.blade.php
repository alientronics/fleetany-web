@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelSensors")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelsensor'))

@role('administrator') 
@section('actions')
{!!Form::actions(array('new' => route("modelsensor.create")))!!}
@stop
@endrole

@section('table')
@role('administrator')  
@if (count($modelsensors) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.Version")}}</th>
            @permission('delete.admin')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modelsensors as $modelsensor) 
        <tr>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->id}}</a></td>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->name}}</a></td>
            <td><a href="{{route('modelsensor.edit', $modelsensor->id)}}">{{$modelsensor->version}}</a></td>
            @permission('delete.admin')
            <td>
                {!!Form::delete(route('modelsensor.destroy',$modelsensor->id))!!}
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
@else
<div class="alert alert-info">
    {{Lang::get("general.norecordsfound")}}
</div>
@endif
@else
<div class="alert alert-info">
    {{Lang::get("general.norecordsfound")}}
</div>
@endrole
                           
@stop

@section("script")

@stop