@extends('layouts.default')
@extends('layouts.table')


@section("title")
<h1>{{Lang::get("general.States")}}</h1>
@stop

@section("sub-title")
{{Lang::get("general.Contacts")}}
@stop

@section('breadcrumbs', Breadcrumbs::render('contact'))

@permission('create.contact') 
@section('actions')
{!!Form::actions(array('new' => route("contact.create")))!!}
@stop
@endpermission

@section('table')
@permission('view.contact')  
@if (count($contacts) > 0)

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
            <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['contact-type']}}">{{Lang::get("general.contact_type")}} <i class="fa fa-fw {{$filters['sort_icon']['contact-type']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['city']}}">{{Lang::get("general.city")}} <i class="fa fa-fw {{$filters['sort_icon']['city']}}"></i></th>
            @permission('delete.contact|update.contact')
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
                  <input type="search" class="form-control" name="name" value="{{$filters['name']}}" placeholder='{{Lang::get("general.name")}}'>
                </div>
            </th> 
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="contact-type" value="{{$filters['contact-type']}}" placeholder='{{Lang::get("general.contact_type")}}'>
                </div>
            </th>    
            <th>
            	<div class="form-group col-sm-10">
                  <input type="search" class="form-control" name="city" value="{{$filters['city']}}" placeholder='{{Lang::get("general.city")}}'>
                </div>
            </th>    
            @permission('delete.contact|update.contact')
            <th>
            	<div class="form-group col-sm-10">
                </div>
            </th>
            @endpermission
        </tr>
    </thead>
    @foreach($contacts as $contact) 
        <tr>
            <td>@if (!empty($contact->id)) {{$contact->id}} @endif</td>
            <td>@if (!empty($contact->name)) {{$contact->name}} @endif</td>   
            <td>@if (!empty($contact->type->name)) {{$contact->type->name}} @endif</td>  
            <td>@if (!empty($contact->city)) {{$contact->city}} @endif</td>  
            @permission('delete.contact|update.contact')
            <td>
            	@permission('update.contact')
                	{!!Form::buttonLink( route('contact.edit', $contact->id) , 'primary' , 'pencil' , 'Editar' )!!}
                @endpermission
            	@permission('delete.contact')
                    {!!Form::buttonLink( url('contact/destroy',$contact->id) , 'danger' , 'trash' , 'Excluir' )!!}
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
</table>
</form>
{!! $contacts->appends($filters)->links() !!}

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