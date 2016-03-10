@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Vehicles")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('vehicle'))

@permission('create.vehicle') 
@section('actions')
{!!Form::actions(array('new' => route("vehicle.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.vehicle')  
@if (count($vehicles) > 0)

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
            <th><a href="{{url('/')}}/{{$filters['sort_url']['model-vehicle']}}">{{Lang::get("general.model_vehicle")}} <i class="fa fa-fw {{$filters['sort_icon']['model-vehicle']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['number']}}">{{Lang::get("general.number")}} <i class="fa fa-fw {{$filters['sort_icon']['number']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['cost']}}">{{Lang::get("general.cost")}} <i class="fa fa-fw {{$filters['sort_icon']['cost']}}"></i></th>
            @permission('delete.vehicle|update.vehicle')
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
                  <input type="search" class="form-control" name="model-vehicle" value="{{$filters['model-vehicle']}}" placeholder='{{Lang::get("general.model_vehicle")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="number" value="{{$filters['number']}}" placeholder='{{Lang::get("general.number")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="cost" value="{{$filters['cost']}}" placeholder='{{Lang::get("general.cost")}}'>
                </div>
            </th> 
            @permission('delete.vehicle|update.vehicle')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($vehicles as $vehicle) 
        <tr>
            <td>@if (!empty($vehicle->id)) {{$vehicle->id}} @endif</td>
            <td>@if (!empty($vehicle->model->name)) {{$vehicle->model->name}} @endif</td>  
            <td>@if (!empty($vehicle->number)) {{$vehicle->number}} @endif</td>  
            <td>@if (!empty($vehicle->cost)) {{$vehicle->cost}} @endif</td>   
            @permission('delete.vehicle|update.vehicle')
            <td>
            	@permission('update.vehicle')
                	{!!Form::buttonLink( route('vehicle.edit', $vehicle->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.vehicle')
                    {!!Form::buttonLink( url('vehicle/destroy',$vehicle->id) , 'danger' , 'trash' , 'Excluir' )!!}
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $vehicles->appends($filters)->links() !!}

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