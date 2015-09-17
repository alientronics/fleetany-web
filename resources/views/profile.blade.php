@extends('layouts.default')

@section('content')

<h1>Perfil</h1>
<p class="lead">Exemplo da p&aacute;gina de perfil.</p>
<hr>

<form id="ProfileForm" class="form-horizontal">

    <div class="form-group">
        <label class="col-xs-3 control-label">Nome</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="name" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Email</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="email" />
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-xs-3 control-label">Criado em: </label>
    </div>
    
    <div class="form-group">
        <label class="col-xs-3 control-label">&Uacute;ltima modifica&ccedil;&atilde;o em: </label>
    </div>

    <div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <button type="submit" class="btn btn-primary" name="send" value="Send">Enviar</button>
        </div>
    </div>
</form>

@stop