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

@permission($operation.'.user')

{!! Form::model('$user', [
        'method'=>'PUT',
        'route' => ['user.update',$user->id]
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
        {!!Form::label('locale', Lang::get('general.locale'))!!}
        {!!Form::select('locale', $locale, $user->locale, array('class' => 'form-control'))!!}
    </div>

    <button type="submit" class="btn btn-primary">{{Lang::get('general.Submit')}}</button>
    <button type="reset" class="btn btn-primary">{{Lang::get('general.Reset')}}</button>
{!! Form::close() !!}

@else
<div class="alert alert-info">
	{{Lang::get("general.acessdenied")}}
</div>
@endpermission

@stop
