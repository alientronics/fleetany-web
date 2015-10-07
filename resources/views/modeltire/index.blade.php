@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelTires")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modeltire'))

@section('actions')
{!!Form::actions(array('new' => route("modeltire.create")))!!}
@stop

@section('table')
@if (count($modeltires) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.pressure_ideal")}}</th>
            <th>{{Lang::get("general.pressure_max")}}</th>
            <th>{{Lang::get("general.pressure_min")}}</th>
            <th>{{Lang::get("general.mileage")}}</th>
            <th>{{Lang::get("general.temp_ideal")}}</th>
            <th>{{Lang::get("general.temp_max")}}</th>
            <th>{{Lang::get("general.temp_min")}}</th>
            <th>{{Lang::get("general.start_diameter")}}</th>
            <th>{{Lang::get("general.start_depth")}}</th>
            <th>{{Lang::get("general.type_land")}}</th>            
            <th>{{Lang::get("general.Actions")}}</th>
        </tr>
    </thead>
    @foreach($modeltires as $modeltire) 
        <tr>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->id}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->name}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->pressure_ideal}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->pressure_max}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->pressure_min}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->mileage}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->temp_ideal}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->temp_max}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->temp_min}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->start_diameter}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->start_depth}}</a></td>
            <td><a href="{{route('modeltire.edit', $modeltire->id)}}">{{$modeltire->type_land}}</a></td>
            <td>
                {!!Form::delete(route('modeltire.destroy',$modeltire->id))!!}
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

$(document).ready(function(){
    $(document).on('submit', '.delete-form', function(){
        return confirm("{{Lang::get("general.areyousure")}}");
    });
});

@stop