@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Type")}}</span>

@stop

@permission('view.type')  

@include('type.filter')

@section('content')

<div class="mdl-grid demo-content">

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['entity-key']}}">{{Lang::get("general.entity_key")}} <i class="fa fa-fw {{$filters['sort_icon']['entity-key']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>
    	  
	    @foreach($types as $type) 
	    	<tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($type->id)) {{$type->id}} @endif</td>
                <td>@if (!empty($type->entity_key)) {{$type->entity_key}} @endif</td>   
                <td>@if (!empty($type->name)) {{$type->name}} @endif</td>  
                @permission('delete.type|update.type')
                <td>
                	@permission('update.type')
                    	{!!Form::buttonLink( route('type.edit', $type->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.type')
                        {!!Form::buttonLink( url('type/destroy',$type->id) , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                    	@include('includes.confirmoperation', ['url' => url('type/destroy',$type->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                    @endpermission
                </td>
                @endpermission
            </tr>
    	@endforeach
    		@include('includes.pagination', ['paginator' => $types->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
     
</div>

@stop

@endpermission