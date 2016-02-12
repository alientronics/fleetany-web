@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelVehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelvehicle'))

@section('actions')
{!!Form::actions(array('new' => route("modelvehicle.create")))!!}
@stop

@section('table')
@if (count($modelvehicles) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.type_vehicle_id")}}</th>
            <th>{{Lang::get("general.year")}}</th>
            <th>{{Lang::get("general.number_of_wheels")}}</th>
            <th>{{Lang::get("general.Actions")}}</th>
        </tr>
    </thead>
    @foreach($modelvehicles as $modelvehicle) 
        <tr>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->id}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->name}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->name}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->year}}</a></td>
            <td><a href="{{route('modelvehicle.edit', $modelvehicle->id)}}">{{$modelvehicle->number_of_wheels}}</a></td>
            <td>
                {!!Form::delete(route('modelvehicle.destroy',$modelvehicle->id))!!}
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