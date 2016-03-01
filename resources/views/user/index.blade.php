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

<div class="form-group col-sm-10">
<select>
	<option>10</option>
	<option>25</option>
	<option>50</option>
	<option>100</option>
</select>
{{Lang::get("general.resultsperpage")}}
</div>

<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th class="col-sm-1">{{Lang::get("general.id")}} <i class="fa fa-fw fa-sort"></i></th>
            <th>{{Lang::get("general.name")}} <i class="fa fa-fw fa-sort"></i></th>    
            <th>{{Lang::get("general.email")}} <i class="fa fa-fw fa-sort"></i></th>
            <th>{{Lang::get("general.contact_id")}} <i class="fa fa-fw fa-sort"></i></th>
            <th>{{Lang::get("general.company_id")}} <i class="fa fa-fw fa-sort"></i></th>
            @permission('delete.user|update.user')
            <th class="col-sm-1">{{Lang::get("general.Actions")}}</th>
            @endpermission
        </tr>
        <tr>
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" placeholder='{{Lang::get("general.name")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" placeholder='{{Lang::get("general.email")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" placeholder='{{Lang::get("general.contact_id")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" placeholder='{{Lang::get("general.company_id")}}'>
                </div>
            </th> 
            @permission('delete.user|update.user')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
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

{!! $users->appends($filters)->links() !!}

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