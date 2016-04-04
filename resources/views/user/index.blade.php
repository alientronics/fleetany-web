@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.User")}}</span>

@stop

@permission('view.user') 

@include('user.filter')

@section('content')

<div class="mdl-grid demo-content">

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['email']}}">{{Lang::get("general.email")}} <i class="fa fa-fw {{$filters['sort_icon']['email']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['contact-id']}}">{{Lang::get("general.contact_id")}} <i class="fa fa-fw {{$filters['sort_icon']['contact-id']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['company-id']}}">{{Lang::get("general.company_id")}} <i class="fa fa-fw {{$filters['sort_icon']['company-id']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>
  
    	  
    	  @foreach($users as $user) 
            <tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($user->id)) {{$user->id}} @endif</td>
                <td>@if (!empty($user->name)) {{$user->name}} @endif</td>  
                <td>@if (!empty($user->email)) {{$user->email}} @endif</td>   
                <td>@if (!empty($user->contact->name)) {{$user->contact->name}} @endif</td> 
                <td>@if (!empty($user->company->name)) {{$user->company->name}} @endif</td>   
                @permission('delete.user|update.user')
                <td>
                	@permission('update.user')
                    	{!!Form::buttonLink( route('user.edit', $user->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.user')
                		@if ($user->id != 1)
                            {!!Form::buttonLink( url('#') , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                        	@include('includes.confirmoperation', ['url' => url('user/destroy',$user->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                        @endif
                    @endpermission
                </td>
                @endpermission
            </tr>
        @endforeach
    		@include('includes.pagination', ['paginator' => $users->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
     
</div>

@stop

@endpermission