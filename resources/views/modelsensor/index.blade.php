@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelSensors")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelsensor'))

@permission('create.modelmonitor') 
@section('actions')
{!!Form::actions(array('new' => route("modelsensor.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.modelsensor')  
@if (count($modelsensors) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.Version")}}</th>
            @permission('delete.modelsensor')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modelsensors as $modelsensor) 
        <tr>
            <td>@permission('update.modelsensor')<a href="{{route('modelsensor.edit', $modelsensor->id)}}">@endpermission{{$modelsensor->id}}@permission('update.modelsensor')</a>@endpermission</td>
            <td>@permission('update.modelsensor')<a href="{{route('modelsensor.edit', $modelsensor->id)}}">@endpermission{{$modelsensor->name}}@permission('update.modelsensor')</a>@endpermission</td>
            <td>@permission('update.modelsensor')<a href="{{route('modelsensor.edit', $modelsensor->id)}}">@endpermission{{$modelsensor->version}}@permission('update.modelsensor')</a>@endpermission</td>
            @permission('delete.modelsensor')
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
@endpermission
                           
@stop

@section("script")

@stop