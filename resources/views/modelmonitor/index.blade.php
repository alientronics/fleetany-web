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
            <td>{{$modelmonitor->id}}</td>
            <td>{{$modelmonitor->name}}</td>
            <td>{{$modelmonitor->version}}</td>
            @permission('delete.modelmonitor|update.modelmonitor')
            <td>
            	@permission('update.modelmonitor')
                	{!!Form::update(route('modelmonitor.edit',$modelmonitor->id))!!}
                @endpermission
            	@permission('delete.modelmonitor')
                	{!!Form::delete(route('modelmonitor.destroy',$modelmonitor->id))!!}
                @endpermission
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