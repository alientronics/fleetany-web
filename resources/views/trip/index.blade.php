@extends('layouts.default')

@section('header')

      @permission('create.trip')
      <a href="{{url('/')}}/trip/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
    	<i class="material-icons">add</i>
      </a>
      @endpermission
      
      <span class="mdl-layout-title">{{Lang::get("general.Trip")}}</span>

@stop

@permission('view.trip')  

@include('trip.filter')

@section('content')

<div class="mdl-grid demo-content">

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['vehicle']}}">{{Lang::get("general.vehicle")}} <i class="fa fa-fw {{$filters['sort_icon']['vehicle']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['trip-type']}}">{{Lang::get("general.trip_type")}} <i class="fa fa-fw {{$filters['sort_icon']['trip-type']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['pickup-date']}}">{{Lang::get("general.pickup_date")}} <i class="fa fa-fw {{$filters['sort_icon']['pickup-date']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['fuel-cost']}}">{{Lang::get("general.fuel_cost")}} <i class="fa fa-fw {{$filters['sort_icon']['fuel-cost']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>

	    @foreach($trips as $trip) 
	    	<tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($trip->id)) {{$trip->id}} @endif</td>
                <td>@if (!empty($trip->vehicle->model->name)) {{$trip->vehicle->model->name}} @endif</td>  
                <td>@if (!empty($trip->type->name)) {{$trip->type->name}} @endif</td>   
                <td>@if (!empty($trip->pickup_date)) {{$trip->pickup_date}} @endif</td>   
                <td>@if (!empty($trip->fuel_cost)) {{$trip->fuel_cost}} @endif</td>   
                @permission('delete.trip|update.trip')
                <td>
                	@permission('update.trip')
                    	{!!Form::buttonLink( route('trip.edit', $trip->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.trip')
                        {!!Form::buttonLink( url('#') , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                    	@include('includes.confirmoperation', ['url' => url('trip/destroy',$trip->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                    @endpermission
                </td>
                @endpermission
            </tr>
	    @endforeach
			@include('includes.pagination', ['paginator' => $trips->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
     
</div>

@stop

@endpermission