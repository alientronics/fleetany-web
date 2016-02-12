@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.User")}}</h1>
@stop

@section('sub-title')
@if ($user->id)
{{$user->name}}
@else
{{Lang::get("general.newuser")}}
@endif
@stop

@section('breadcrumbs', Breadcrumbs::render('user.edit', $user))

@section('edit')

@if (!$user->id)
{!! Form::open(array('route' => 'user.store')) !!}
@else
{!! Form::model('$user', [
        'method'=>'PUT',
        'route' => ['user.update',$user->id]
    ]) !!}
@endif
    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $user->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('email', Lang::get('general.email'))!!}
        {!!Form::text('email', $user->email, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('password', Lang::get('general.password'))!!}
        {!!Form::password('password', $user->password, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('contact_id', Lang::get('general.contact_id'))!!}
        {!!Form::text('contact_id', $user->contact_id, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('company_id', Lang::get('general.company_id'))!!}
        {!!Form::text('company_id', $user->company_id, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@stop