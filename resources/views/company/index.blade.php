@extends('layouts.default')

@section("title")
{{Lang::get("general.States")}}
@stop

@section("sub-title")
{{Lang::get("general.Companies")}}
@stop

@permission('create.company') 
@section('actions')
<!-- {!!Form::actions(array('new' => route("company.create")))!!} -->
@stop
@endpermission

@section('content')
@permission('view.company')  
@if (count($companies) > 0)

	<table class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
	  <thead>
		<tr>
		  	<th class="col-sm-1"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}} <i class="fa fa-fw {{$filters['sort_icon']['id']}}"></i></a></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['name']}}">{{Lang::get("general.name")}} <i class="fa fa-fw {{$filters['sort_icon']['name']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['city']}}">{{Lang::get("general.city")}} <i class="fa fa-fw {{$filters['sort_icon']['city']}}"></i></th>
            <th><a href="{{url('/')}}/{{$filters['sort_url']['country']}}">{{Lang::get("general.country")}} <i class="fa fa-fw {{$filters['sort_icon']['country']}}"></i></th>
            @permission('delete.company|update.company')
            <th class="col-sm-1">{{Lang::get("general.Actions")}}</th>
            @endpermission
		</tr>
		<tr>
		  <th></th>
		  <th>
			<div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
				<input class="mdl-textfield__input" type="text" name="name" value="{{$filters['name']}}">
				<label class="mdl-textfield__label" for="name">{{Lang::get("general.name")}}</label>
			  </div>
		  </th>
		  <th>
			<div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
				<input class="mdl-textfield__input" type="text" name="city" value="{{$filters['city']}}">
				<label class="mdl-textfield__label" for="city">{{Lang::get("general.city")}}</label>
			  </div>
		  </th>
		  <th>
			<div class="mdl-textfield mdl-js-textfield mdl-cell--8-col">
				<input class="mdl-textfield__input" type="text" name="country" value="{{$filters['country']}}">
				<label class="mdl-textfield__label" for="country">{{Lang::get("general.country")}}</label>
			  </div>
		  </th>
		  <th></th>
		</tr>
	  </thead>
	  <tbody>
	  
	  @foreach($companies as $company) 
        <tr>
            <td class="mdl-data-table__cell--non-numeric">@if (!empty($company->id)) {{$company->id}} @endif</td>
            <td>@if (!empty($company->name)) {{$company->name}} @endif</td>  
            <td>@if (!empty($company->city)) {{$company->city}} @endif</td>   
            <td>@if (!empty($company->country)) {{$company->country}} @endif</td>   
            @permission('delete.company|update.company')
            <td>
            	@permission('update.company')
                	{!!Form::buttonLink( route('company.edit', $company->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                @endpermission
            	@permission('delete.company')
                    {!!Form::buttonLink( url('company/destroy',$company->id) , 'danger' , 'delete' , 'Excluir' )!!}
                @endpermission
            </td>
            @endpermission
        </tr>
    @endforeach
	  </tbody>
	</table>

{!! $companies->appends($filters)->links() !!}

@else
<!-- <div class="alert alert-info"> -->
<!--     {{Lang::get("general.norecordsfound")}} -->
<!-- </div> -->
@endif
@else
<!-- <div class="alert alert-info"> -->
<!-- 	{{Lang::get("general.acessdenied")}} -->
<!-- </div> -->
@endpermission
                           
@stop

@section("script")

<!-- $(document).ready(function(){ -->
<!--     $(document).on('submit', '.delete-form', function(){ -->
<!--         return confirm("{{Lang::get("general.areyousure")}}"); -->
<!--     }); -->
<!-- }); -->

@stop