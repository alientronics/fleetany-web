@extends('layouts.default')

@section('header')

      @permission('create.company')
      <a href="{{url('/')}}/company/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
    	<i class="material-icons">add</i>
      </a>
      @endpermission
      
      <span class="mdl-layout-title">{{Lang::get("general.Company")}}</span>

@stop

@include('company.filter')

@section('content')

<div class="mdl-grid demo-content">

@permission('view.company')  

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['city']}}">{{Lang::get("general.city")}} <i class="fa fa-fw {{$filters['sort_icon']['city']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['country']}}">{{Lang::get("general.country")}} <i class="fa fa-fw {{$filters['sort_icon']['country']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>
    	  
    	  @include('includes.confirmoperation', ['confirm' => Lang::get("general.areyousuredelete")]) 
    	  @foreach($companies as $company) 
            <tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($company->id)) {{$company->id}} @endif</td>
                <td>@if (!empty($company->name)) {{$company->name}} @endif</td>  
                <td>@if (!empty($company->city)) {{$company->city}} @endif</td>   
                <td>@if (!empty($company->country)) {{$company->country}} @endif</td>   
                @permission('delete.company|update.company')
                <td>
                	@permission('update.company')
                    	{!!Form::buttonLink( route('company.edit', $company->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.company')
                        {!!Form::buttonLink( url('company/destroy',$company->id) , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                	@endpermission
                </td>
                @endpermission
            </tr>
        @endforeach
    		@include('includes.pagination', ['paginator' => $companies->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
	
@endpermission

</div>

@stop