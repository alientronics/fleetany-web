@extends('layouts.default')

@section('header')

      @permission('create.entry')
      <a href="{{url('/')}}/entry/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
    	<i class="material-icons">add</i>
      </a>
      @endpermission
      
      <span class="mdl-layout-title">{{Lang::get("general.Entry")}}</span>

@stop

@include('entry.filter')

@section('content')

<div class="mdl-grid demo-content">

@permission('view.entry')

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['vehicle']}}">{{Lang::get("general.vehicle")}} <i class="fa fa-fw {{$filters['sort_icon']['vehicle']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['entry-type']}}">{{Lang::get("general.entry_type")}} <i class="fa fa-fw {{$filters['sort_icon']['entry-type']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['datetime-ini']}}">{{Lang::get("general.datetime_ini")}} <i class="fa fa-fw {{$filters['sort_icon']['datetime-ini']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['cost']}}">{{Lang::get("general.cost")}} <i class="fa fa-fw {{$filters['sort_icon']['cost']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>

	    @foreach($entries as $entry) 
	    	<tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($entry->id)) {{$entry->id}} @endif</td>
                <td>@if (!empty($entry->vehicle->model->name)) {{$entry->vehicle->model->name}} @endif</td>  
                <td>@if (!empty($entry->type->name)) {{$entry->type->name}} @endif</td>   
                <td>@if (!empty($entry->datetime_ini)) {{$entry->datetime_ini}} @endif</td> 
                <td>@if (!empty($entry->cost)) {{$entry->cost}} @endif</td>   
                @permission('delete.entry|update.entry')
                <td>
                	@permission('update.entry')
                    	{!!Form::buttonLink( route('entry.edit', $entry->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.entry')
                        {!!Form::buttonLink( url('entry/destroy',$entry->id) , 'danger' , 'delete' , 'Excluir' )!!}
                    @endpermission
                </td>
                @endpermission
            </tr>
    	@endforeach
    		@include('includes.pagination', ['paginator' => $entries->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
	
@endpermission
     
</div>

@stop