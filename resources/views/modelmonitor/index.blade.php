@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.ModelMonitors")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('modelmonitor'))

@role('administrator') 
@section('actions')
{!!Form::actions(array('new' => route("modelmonitor.create")))!!}
@stop
@endrole

@section('table')
@role('administrator') 
@if (count($modelmonitors) > 0)
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
    @foreach($modelmonitors as $modelmonitor) 
        <tr>
            <td><a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">{{$modelmonitor->id}}</a></td>
            <td><a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">{{$modelmonitor->name}}</a></td>
            <td><a href="{{route('modelmonitor.edit', $modelmonitor->id)}}">{{$modelmonitor->version}}</a></td>
            @permission('delete.admin')
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
@endrole
                        
@stop

@section("script")

@stop