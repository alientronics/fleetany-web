@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelVehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelvehicle'))

@role('administrator') 
@section('actions')
{!!Form::actions(array('new' => route("modelvehicle.create")))!!}
@stop
@endrole

@section('table')
@role('administrator') 
@if (count($modelvehicles) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.type_vehicle_id")}}</th>
            <th>{{Lang::get("general.year")}}</th>
            <th>{{Lang::get("general.number_of_wheels")}}</th>
            @permission('delete.admin')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modelvehicles as $modelvehicle) 
        <tr>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->id}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->name}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->typeVehicle->name}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->year}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->number_of_wheels}}</a></td>
            @permission('delete.admin')
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
@endrole 
                           
@stop

@section("script")

@stop