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
<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Welcome</h2>
  </div>
  <div class="mdl-card__supporting-text">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1">
        <label class="mdl-textfield__label" for="sample1">Text...</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1">
        <label class="mdl-textfield__label" for="sample1">Text...</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1">
        <label class="mdl-textfield__label" for="sample1">Text...</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sample1">
        <label class="mdl-textfield__label" for="sample1">Text...</label>
      </div>
  </div>
  <div class="mdl-card__actions mdl-card--border mdl-cell--12-col">
  <button class="mdl-button mdl-button--colored">
      Enviar
    </button>
  </div>
</div>
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop