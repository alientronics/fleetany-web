@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.TypeVehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('typevehicle'))

@permission('create.typevehicle') 
@section('actions')
{!!Form::actions(array('new' => route("typevehicle.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.typevehicle') 
@if (count($typevehicles) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>    
            @permission('delete.typevehicle') 
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($typevehicles as $typevehicle) 
        <tr>
            <td>@permission('update.typevehicle')<a href="{{route('typevehicle.edit', $typevehicle->id)}}">@endpermission{{$typevehicle->id}}@permission('update.typevehicle')</a>@endpermission</td>
            <td>@permission('update.typevehicle')<a href="{{route('typevehicle.edit', $typevehicle->id)}}">@endpermission{{$typevehicle->name}}@permission('update.typevehicle')</a>@endpermission</td>
            @permission('delete.typevehicle')
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
@endpermission
                           
@stop

@section("script")

@stop