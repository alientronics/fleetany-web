@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Trips")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('trip'))

@permission('create.trip') 
@section('actions')
{!!Form::actions(array('new' => route("trip.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.trip')  
@if (count($trips) > 0)

<form method="get" id="search">

<div class="form-group col-sm-10">
<select name="paginate">
	<option @if ($filters['paginate'] == 10) selected @endif value="10">10</option>
	<option @if ($filters['paginate'] == 25) selected @endif value="25">25</option>
	<option @if ($filters['paginate'] == 50) selected @endif value="50">50</option>
	<option @if ($filters['paginate'] == 100) selected @endif value="100">100</option>
</select>
{{Lang::get("general.resultsperpage")}}
</div>

<input type="submit" value="Pesquisar" />
<input type="hidden" name="sort" value="{{$filters['sort']}}-{{$filters['order']}}" />

<table class='table table-striped table-bordered table-hover'>
    <thead>
        <tr>
            <th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['vehicle-id']}}">{{Lang::get("general.vehicle_id")}} <i class="fa fa-fw {{$filters['sort_icon']['vehicle-id']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['trip-type-id']}}">{{Lang::get("general.trip_type_id")}} <i class="fa fa-fw {{$filters['sort_icon']['trip-type-id']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['pickup-date']}}">{{Lang::get("general.pickup_date")}} <i class="fa fa-fw {{$filters['sort_icon']['pickup-date']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['fuel-cost']}}">{{Lang::get("general.fuel_cost")}} <i class="fa fa-fw {{$filters['sort_icon']['fuel-cost']}}"></i></th>
            @permission('delete.trip|update.trip')
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
                  <input type="search" class="form-control" name="vehicle-id" value="{{$filters['vehicle-id']}}" placeholder='{{Lang::get("general.vehicle_id")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="trip-type-id" value="{{$filters['trip-type-id']}}" placeholder='{{Lang::get("general.trip_type_id")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="pickup-date" value="{{$filters['pickup-date']}}" placeholder='{{Lang::get("general.pickup_date")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="fuel-cost" value="{{$filters['fuel-cost']}}" placeholder='{{Lang::get("general.fuel_cost")}}'>
                </div>
            </th> 
            @permission('delete.trip|update.trip')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($trips as $trip) 
        <tr>
            <td>{{$trip->id}}</td>
            <td>{{$trip->vehicle_id}}</td>  
            <td>{{$trip->trip_type_id}}</td>  
            <td>{{$trip->pickup_date}}</td>  
            <td>{{$trip->fuel_cost}}</td>   
            @permission('delete.trip|update.trip')
            <td>
            	@permission('update.trip')
                	{!!Form::buttonLink( route('trip.edit', $trip->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.trip')
            		@if ($trip->id != 1)
                        {!!Form::buttonLink( url('trip/destroy',$trip->id) , 'danger' , 'trash' , 'Excluir' )!!}
                	@endif
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $trips->appends($filters)->links() !!}

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