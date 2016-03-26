@extends('layouts.default')

@section('header')

      @permission('create.vehicle')
      <a href="{{url('/')}}/vehicle/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
    	<i class="material-icons">add</i>
      </a>
      @endpermission
      
      <span class="mdl-layout-title">{{Lang::get("general.Vehicle")}}</span>

@stop

@include('vehicle.filter')

@section('content')

<div class="mdl-grid demo-content">

@permission('view.vehicle')  

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['model-vehicle']}}">{{Lang::get("general.model_vehicle")}} <i class="fa fa-fw {{$filters['sort_icon']['model-vehicle']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['number']}}">{{Lang::get("general.number")}} <i class="fa fa-fw {{$filters['sort_icon']['number']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['cost']}}">{{Lang::get("general.cost")}} <i class="fa fa-fw {{$filters['sort_icon']['cost']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>

    	  @foreach($vehicles as $vehicle) 
            <tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($vehicle->id)) {{$vehicle->id}} @endif</td>
                <td>@if (!empty($vehicle->model->name)) {{$vehicle->model->name}} @endif</td>  
                <td>@if (!empty($vehicle->number)) {{$vehicle->number}} @endif</td>   
                <td>@if (!empty($vehicle->cost)) {{$vehicle->cost}} @endif</td>   
                @permission('delete.vehicle|update.vehicle')
                <td>
                	@permission('update.vehicle')
                    	{!!Form::buttonLink( route('vehicle.edit', $vehicle->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.vehicle')
                        {!!Form::buttonLink( url('vehicle/destroy',$vehicle->id) , 'danger' , 'delete' , 'Excluir' )!!}
                    @endpermission
                </td>
                @endpermission
            </tr>
        @endforeach
    		@include('includes.pagination', ['paginator' => $vehicles->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
	
@endpermission
     
</div>

@stop    	  