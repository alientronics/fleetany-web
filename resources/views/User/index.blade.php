@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Users")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('user'))

@section('actions')
{!!Form::actions(array('new' => route("user.create")))!!}
@stop

@section('table')
@if (count($users) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>    
            <th>{{Lang::get("general.email")}}</th>
            <th>{{Lang::get("general.contact_id")}}</th>
            <th>{{Lang::get("general.company_id")}}</th>
            <th>{{Lang::get("general.Actions")}}</th>
        </tr>
    </thead>
    @foreach($users as $user) 
        <tr>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->id}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->name}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->email}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->contact_id}}</a></td>
            <td><a href="{{route('user.edit', $user->id)}}">{{$user->company_id}}</a></td>             
            <td>
                {!!Form::delete(route('user.destroy',$user->id))!!}
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