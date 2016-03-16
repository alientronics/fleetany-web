@extends('layouts.default')

@section('title')
<h1>{{Lang::get("general.Vehicles")}}</h1>
@stop

@section('sub-title')
@if ($company->id)
{{--*/ $operation = 'update' /*--}}
{{$company->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newcompany")}}
@endif
@stop

@if ($company->id)
@section('breadcrumbs', Breadcrumbs::render('company.edit', $company))
@endif

@section('content')

@permission($operation.'.company')

@if (!$company->id)
{!! Form::open(array('route' => 'company.store')) !!}
@else
{!! Form::model('$company', [
        'method'=>'PUT',
        'route' => ['company.update',$company->id]
    ]) !!}
@endif
<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
          </div>
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop