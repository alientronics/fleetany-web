@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Users")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('user'))

@role('administrator|gestor') 
@section('actions')
{!!Form::actions(array('new' => route("user.create")))!!}
@stop
@endrole

@section('table')
@role('administrator|gestor') 
@if (count($users) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>    
            <th>{{Lang::get("general.email")}}</th>
            <th>{{Lang::get("general.contact_id")}}</th>
            <th>{{Lang::get("general.company_id")}}</th>
            @permission('delete.admin')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($users as $user) 
    	@if ($user->id != 1) 
        <tr>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->id}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->name}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->email}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->contact_id}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->company_id}}</a></td>   
            @permission('delete.admin')          
            <td>
                {!!Form::delete(route('user.destroy',$user->id))!!}
            </td>
            @endpermission
        </tr>
        @endif
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

$(document).ready(function(){
    $(document).on('submit', '.delete-form', function(){
        return confirm("{{Lang::get("general.areyousure")}}");
    });
});

@stop