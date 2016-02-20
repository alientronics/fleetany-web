@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelVehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelvehicle'))

@permission('create.modelvehicle')
@section('actions')
{!!Form::actions(array('new' => route("modelvehicle.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.modelvehicle') 
@if (count($modelvehicles) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.type_vehicle_id")}}</th>
            <th>{{Lang::get("general.year")}}</th>
            <th>{{Lang::get("general.number_of_wheels")}}</th>
            @permission('delete.modelvehicle')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modelvehicles as $modelvehicle) 
        <tr>
            <td>@permission('update.modelvehicle')<a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">@endpermission{{$modelvehicle->id}}@permission('update.modelvehicle')</a>@endpermission</td>
            <td>@permission('update.modelvehicle')<a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">@endpermission{{$modelvehicle->name}}@permission('update.modelvehicle')</a>@endpermission</td>
            <td>@permission('update.modelvehicle')<a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">@endpermission{{$modelvehicle->typeVehicle->name}}@permission('update.modelvehicle')</a>@endpermission</td>
            <td>@permission('update.modelvehicle')<a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">@endpermission{{$modelvehicle->year}}@permission('update.modelvehicle')</a>@endpermission</td>
            <td>@permission('update.modelvehicle')<a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">@endpermission{{$modelvehicle->number_of_wheels}}@permission('update.modelvehicle')</a>@endpermission</td>
            @permission('delete.modelvehicle')
            <td>
                {!!Form::delete(route('modelvehicle.destroy',$modelvehicle->id))!!}
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
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission 
                           
@stop

@section("script")

@stop