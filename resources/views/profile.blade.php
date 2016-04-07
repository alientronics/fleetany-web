@extends('layouts.default')

@section('header')
	<span class="mdl-layout-title">{{$user->name}}</span>
@stop

@section('content')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

{!! Form::model('$user', [
        'method'=>'PUT',
        'action' => ['UserController@updateProfile', $user->id ]
    ]) !!}

			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('name', $user->name, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
			</div>
						
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('email')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('email', $user->email, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('email', Lang::get('general.email'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
			</div>
						
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('password')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::password('password', array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('password', Lang::get('general.password'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
			</div>

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('language')) is-invalid is-dirty @endif"">
                {!!Form::select('language', $language, $user->language, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('language', Lang::get('general.language'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('language') }}</span>
            </div>
						
			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored">
                  {{ Lang::get('general.Send') }} 
                </button>
			</div>
	
{!! Form::close() !!}

		</div>
	</section>
</div>

@stop