@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.TypeVehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('typevehicle'))

@role('administrator') 
@section('actions')
{!!Form::actions(array('new' => route("typevehicle.create")))!!}
@stop
@endrole

@section('table')
@role('administrator') 
@if (count($typevehicles) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>    
            @permission('delete.admin') 
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($typevehicles as $typevehicle) 
        <tr>
            <td><a href="{{route('typevehicle.edit', $typevehicle->id)}}">{{$typevehicle->id}}</a></td>
            <td><a href="{{route('typevehicle.edit', $typevehicle->id)}}">{{$typevehicle->name}}</a></td>
            @permission('delete.admin')
            <td>
                {!!Form::delete(route('typevehicle.destroy',$typevehicle->id))!!}
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