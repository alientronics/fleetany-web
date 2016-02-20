@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelTires")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modeltire'))

@permission('create.modeltire') 
@section('actions')
{!!Form::actions(array('new' => route("modeltire.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.modeltire')  
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
            @permission('delete.modeltire')          
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modeltires as $modeltire) 
        <tr>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->id}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->name}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->pressure_ideal}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->pressure_max}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->pressure_min}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->mileage}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->temp_ideal}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->temp_max}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->temp_min}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->start_diameter}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->start_depth}}@permission('update.modeltire')</a>@endpermission</td>
            <td>@permission('update.modeltire')<a href="{{route('modeltire.edit', $modeltire->id)}}">@endpermission{{$modeltire->type_land}}@permission('update.modeltire')</a>@endpermission</td>
            @permission('delete.modeltire')
            <td>
                {!!Form::delete(route('modeltire.destroy',$modeltire->id))!!}
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