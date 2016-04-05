<div class="mdl-cell mdl-cell--12-col mdl-grid">
	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--1-col"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}}</a></div>
          <div class="mdl-cell mdl-cell--3-col"><a href="{{url('/')}}/{{$filters['sort_url']['vehicle']}}">{{Lang::get("general.vehicle")}}</a></div>
          <div class="mdl-cell mdl-cell--3-col"><a href="{{url('/')}}/{{$filters['sort_url']['trip-type']}}">{{Lang::get("general.trip_type")}}</a></div>
          <div class="mdl-cell mdl-cell--2-col"><a href="{{url('/')}}/{{$filters['sort_url']['pickup-date']}}">{{Lang::get("general.pickup_date")}}</a></div>
          <div class="mdl-cell mdl-cell--2-col"><a href="{{url('/')}}/{{$filters['sort_url']['fuel-cost']}}">{{Lang::get("general.fuel_cost")}}</a></div>
          @permission('delete.trip|update.trip')
          <div class="mdl-cell mdl-cell--1-col"></div>
          @endpermission
        </div>
    </div>
    
    
    @foreach($trips as $trip)
    <div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--1-col mdl-data-table__cell--non-numeric">@if (!empty($trip->id)) {{$trip->id}} @endif</div>
          <div class="mdl-cell mdl-cell--3-col">@if (!empty($trip->vehicle->model->name)) {{$trip->vehicle->model->name}} @endif</div>
          <div class="mdl-cell mdl-cell--3-col">@if (!empty($trip->type->name)) {{$trip->type->name}} @endif</div>
          <div class="mdl-cell mdl-cell--2-col">@if (!empty($trip->pickup_date)) {{$trip->pickup_date}} @endif</div>
          <div class="mdl-cell mdl-cell--2-col">@if (!empty($trip->fuel_cost)) {{$trip->fuel_cost}} @endif</div>
          @permission('delete.trip|update.trip')
          <div class="mdl-cell mdl-cell--1-col">
          		@permission('update.trip')
                	{!!Form::buttonLink( route('trip.edit', $trip->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                @endpermission
            	@permission('delete.trip')
                    {!!Form::buttonLink( url('trip/destroy',$trip->id) , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                	@include('includes.confirmoperation', ['url' => url('trip/destroy',$trip->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                @endpermission
          </div>
          @endpermission
        </div>
    </div>
    @endforeach
	@include('includes.pagination', ['paginator' => $trips->appends($filters['pagination'])]) 

</div>