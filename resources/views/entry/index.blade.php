@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Entries")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('entry'))

@permission('create.entry') 
@section('actions')
{!!Form::actions(array('new' => route("entry.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.entry')  
@if (count($entries) > 0)

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
            <th><a href="{{url('/')}}/{{$filters['sort_url']['cost']}}">{{Lang::get("general.cost")}} <i class="fa fa-fw {{$filters['sort_icon']['cost']}}"></i></th>
            @permission('delete.entry|update.entry')
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
                  <input type="search" class="form-control" name="cost" value="{{$filters['cost']}}" placeholder='{{Lang::get("general.cost")}}'>
                </div>
            </th> 
            @permission('delete.entry|update.entry')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($entries as $entry) 
        <tr>
            <td>{{$entry->id}}</td>
            <td>{{$entry->cost}}</td>   
            @permission('delete.entry|update.entry')
            <td>
            	@permission('update.entry')
                	{!!Form::buttonLink( route('entry.edit', $entry->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.entry')
            		@if ($entry->id != 1)
                        {!!Form::buttonLink( url('entry/destroy',$entry->id) , 'danger' , 'trash' , 'Excluir' )!!}
                	@endif
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $entries->appends($filters)->links() !!}

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