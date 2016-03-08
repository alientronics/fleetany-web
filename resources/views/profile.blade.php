@extends('layouts.default')
@extends('layouts.edit')

@section('title')
<h1>{{Lang::get("general.User")}}</h1>
@stop

@section('sub-title')
@if ($user->id)
{{--*/ $operation = 'update' /*--}}
{{$user->name}}
@else
{{--*/ $operation = 'create' /*--}}
{{Lang::get("general.newuser")}}
@endif
@stop

@if ($user->id)
@section('breadcrumbs', Breadcrumbs::render('user.edit', $user))
@endif

@section('edit')

{!! Form::model('$user', [
        'method'=>'PUT',
        'action' => ['UserController@updateProfile', $user->id ]
    ]) !!}

    <div class="form-group col-lg-12">
        {!!Form::label('name', Lang::get('general.name'))!!}
        {!!Form::text('name', $user->name, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('email', Lang::get('general.email'))!!}
        {!!Form::text('email', $user->email, array('class' => 'form-control'))!!}
    </div>

    <div class="form-group col-lg-12">
        {!!Form::label('language', Lang::get('general.language'))!!}
        {!!Form::select('language', $language, $user->language, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@stop
