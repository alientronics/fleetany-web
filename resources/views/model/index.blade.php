@extends('layouts.default')

@section('header')

      @permission('create.model')
      <a href="{{url('/')}}/model/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
    	<i class="material-icons">add</i>
      </a>
      @endpermission
      
      <span class="mdl-layout-title">{{Lang::get("general.Model")}}</span>

@stop

@include('model.filter')

@section('content')

<div class="mdl-grid demo-content">

@permission('view.model')  

    <div class="mdl-cell mdl-cell--12-col mdl-grid">

    	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    	  <thead>
    		<tr>
    		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['model-type']}}">{{Lang::get("general.model_type")}} <i class="fa fa-fw {{$filters['sort_icon']['model-type']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['vendor']}}">{{Lang::get("general.vendor")}} <i class="fa fa-fw {{$filters['sort_icon']['vendor']}}"></i></th>
                <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
                <th></th>
    		</tr>
    	  </thead>
    	  <tbody>
    	  
    	  @foreach($models as $model) 
            <tr>
                <td class="mdl-data-table__cell--non-numeric">@if (!empty($model->id)) {{$model->id}} @endif</td>
                <td>@if (!empty($model->type->name)) {{$model->type->name}} @endif</td>  
                <td>@if (!empty($model->contact->name)) {{$model->contact->name}} @endif</td>   
                <td>@if (!empty($model->name)) {{$model->name}} @endif</td>   
                @permission('delete.model|update.model')
                <td>
                	@permission('update.model')
                    	{!!Form::buttonLink( route('model.edit', $model->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                    @endpermission
                	@permission('delete.model')
                        {!!Form::buttonLink( url('model/destroy',$model->id) , 'danger' , 'delete' , 'Excluir' )!!}
                    @endpermission
                </td>
                @endpermission
            </tr>
        @endforeach    	  
    		@include('includes.pagination', ['paginator' => $models->appends($filters['pagination'])]) 
    	  </tbody>
    	</table>

    </div>
	
@endpermission
     
</div>

@stop    	  