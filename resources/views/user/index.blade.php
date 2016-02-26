@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Users")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('user'))

@permission('create.user') 
@section('actions')
{!!Form::actions(array('new' => route("user.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.user')  
@if (count($users) > 0)
<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th>{{Lang::get("general.id")}}</th>
            <th>{{Lang::get("general.name")}}</th>    
            <th>{{Lang::get("general.email")}}</th>
            <th>{{Lang::get("general.contact_id")}}</th>
            <th>{{Lang::get("general.company_id")}}</th>
            @permission('delete.user|update.user')
            <th>{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
    </thead>
    @foreach($users as $user) 
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->contact_id}}</td>
            <td>{{$user->company_id}}</td>   
            @permission('delete.user|update.user')
            <td>
            	@permission('update.user')
                	{!!Form::buttonLink( route('user.edit', $user->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.user')
            		@if ($user->id != 1)
                        {!!Form::buttonLink( url('user/destroy',$user->id) , 'danger' , 'trash' , 'Excluir' )!!}
                	@endif
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

$(document).ready(function(){
    $(document).on('submit', '.delete-form', function(){
        return confirm("{{Lang::get("general.areyousure")}}");
    });
});

@stop