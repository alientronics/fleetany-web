@extends('layouts.default')

@section('content')

@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif

<h1>Perfil</h1>
<p class="lead">Exemplo da p&aacute;gina de perfil.</p>
<hr>

{!! Form::model($user, [
    'method' => 'PATCH',
    'route' => ['user.update', $user->id]
]) !!}

<div class="form-group">
    {!! Form::label('name', 'Nome:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email:', ['class' => 'control-label']) !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

@stop