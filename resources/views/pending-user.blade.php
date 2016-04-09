@extends('layouts.default')

@section('header')
	<span class="mdl-layout-title">{{Lang::get('general.PendingUser')}}</span>
@stop

@section('content')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

{!! Form::model('$user', [
        'method'=>'PUT',
        'action' => ['UserController@pending']
    ]) !!}

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('email')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('email', "", array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('email', Lang::get('general.email'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
			</div>
						
			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
                  {{ Lang::get('general.Send') }} 
                </button>
			</div>
					
{!! Form::close() !!}

		</div>
	</section>
</div>

@stop