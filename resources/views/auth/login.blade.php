@extends('layouts.login')

@section('content')
<div class="mdl-layout mdl-js-layout mdl-color--grey-100">
	<main class="mdl-layout__content">
		<div class="mdl-card mdl-shadow--6dp">
			<img src='{{URL::asset('images/alientronics.png')}}' height='200'>
			{!! Form::open() !!}
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">{{Lang::get('general.PleaseSignIn')}}</h2>
			</div>
	  		<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="text" id="email" name="email" />
						<label class="mdl-textfield__label" for="email">E-mail</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						<input class="mdl-textfield__input" type="password" id="password" name="password" />
						<label class="mdl-textfield__label" for="password">Password</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
    					<input name="remember" type="checkbox" value="Remember Me">{{Lang::get("general.RememberMe")}}
					</div>
			</div>
			<div class="mdl-card__actions mdl-card--border">
				<button type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Log in</button>
			</div>
			{!! Form::close() !!}
			<div class="mdl-card__actions mdl-card--border">
				<a href="{{url('/')}}/auth/social/google" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">{{Lang::get("general.LoginGoogle")}}</a>
            </div>
			<div class="mdl-card__actions mdl-card--border">
				<a href="{{url('/')}}/auth/social/facebook" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">{{Lang::get("general.LoginFacebook")}}</a>
        	</div>
		</div>
	</main>
</div>
@endsection
