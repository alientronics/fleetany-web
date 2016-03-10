@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Types")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('type'))

@permission('create.type') 
@section('actions')
{!!Form::actions(array('new' => route("type.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.type')  
@if (count($types) > 0)

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
            <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
            @permission('delete.type|update.type')
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
                  <input type="search" class="form-control" name="name" value="{{$filters['name']}}" placeholder='{{Lang::get("general.name")}}'>
                </div>
            </th> 
            @permission('delete.type|update.type')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($types as $type) 
        <tr>
            <td>{{$type->id}}</td>
            <td>{{$type->company_id}}</td>  
            <td>{{$type->name}}</td>   
            @permission('delete.type|update.type')
            <td>
            	@permission('update.type')
                	{!!Form::buttonLink( route('type.edit', $type->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.type')
            		@if ($type->id != 1)
                        {!!Form::buttonLink( url('type/destroy',$type->id) , 'danger' , 'trash' , 'Excluir' )!!}
                	@endif
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $types->appends($filters)->links() !!}

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