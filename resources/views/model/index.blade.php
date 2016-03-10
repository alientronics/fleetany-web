@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Models")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('model'))

@permission('create.model') 
@section('actions')
{!!Form::actions(array('new' => route("model.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.model')  
@if (count($models) > 0)

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
            <th><a href="{{url('/')}}/{{$filters['sort_url']['company-id']}}">{{Lang::get("general.company_id")}} <i class="fa fa-fw {{$filters['sort_icon']['company-id']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['model-type-id']}}">{{Lang::get("general.model_type_id")}} <i class="fa fa-fw {{$filters['sort_icon']['model-type-id']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['vendor-id']}}">{{Lang::get("general.vendor_id")}} <i class="fa fa-fw {{$filters['sort_icon']['vendor-id']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
            @permission('delete.model|update.model')
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
                  <input type="search" class="form-control" name="company-id" value="{{$filters['company-id']}}" placeholder='{{Lang::get("general.company_id")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="model-type-id" value="{{$filters['model-type-id']}}" placeholder='{{Lang::get("general.model_type_id")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="vendor-id" value="{{$filters['vendor-id']}}" placeholder='{{Lang::get("general.vendor_id")}}'>
                </div>
            </th>     
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="name" value="{{$filters['name']}}" placeholder='{{Lang::get("general.name")}}'>
                </div>
            </th> 
            @permission('delete.model|update.model')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($models as $model) 
        <tr>
            <td>{{$model->id}}</td>
            <td>{{$model->company_id}}</td>  
            <td>{{$model->model_type_id}}</td>  
            <td>{{$model->vendor_id}}</td>   
            <td>{{$model->name}}</td>   
            @permission('delete.model|update.model')
            <td>
            	@permission('update.model')
                	{!!Form::buttonLink( route('model.edit', $model->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.model')
            		@if ($model->id != 1)
                        {!!Form::buttonLink( url('model/destroy',$model->id) , 'danger' , 'trash' , 'Excluir' )!!}
                	@endif
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $models->appends($filters)->links() !!}

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