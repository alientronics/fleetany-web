@extends('layouts.login')

@section('content')
<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary">
                    <div class="panel-heading">
                        <img src='{{URL::asset('images/alientronics.png')}}' height='40'>
                        <div class="pull-right">
                                <h3 class="panel-title">{{Lang::get('general.PleaseSignIn')}}</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                       {!! Form::open() !!}
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">{{Lang::get("general.RememberMe")}}
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                            </fieldset>
                       {!! Form::close() !!}
                    </div>
                    <div class="panel-body">
                    	<p class="text-center">
            	            <a href="{{url('/')}}/auth/social/google"><i class="fa fa-google"></i> Google</a> </br></br>
            	            <a href="{{url('/')}}/auth/social/facebook"><i class="fa fa-facebook"></i> Facebook</a>
                    	</p>
                    </div>
                </div>
            </div>
        </div>
@endsection

