@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelMonitors")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelmonitor'))

@permission('create.modelmonitor') 
@section('actions')
{!!Form::actions(array('new' => route("modelmonitor.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.modelmonitor') 
@if (count($modelmonitors) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>
            <th>{{Lang::get("general.Version")}}</th>
            @permission('delete.modelmonitor')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($modelmonitors as $modelmonitor) 
        <tr>
            <td>@permission('update.modelmonitor')<a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">@endpermission {{$modelmonitor->id}} @permission('update.modelmonitor')</a>@endpermission </td>
            <td>@permission('update.modelmonitor')<a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">@endpermission {{$modelmonitor->name}} @permission('update.modelmonitor')</a>@endpermission </td>
            <td>@permission('update.modelmonitor')<a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">@endpermission {{$modelmonitor->version}} @permission('update.modelmonitor')</a>@endpermission </td>
            @permission('delete.modelmonitor')
            <td>
                {!!Form::delete(route('modelmonitor.destroy',$modelmonitor->id))!!}
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