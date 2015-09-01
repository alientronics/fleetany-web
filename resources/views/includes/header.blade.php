<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{URL::asset("/")}}"><img src='{{URL::asset('images/alientronics.jpg')}}' height='20'></a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        @if (Auth::check())
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> Administrator <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{URL::asset("profile")}}"><i class="fa fa-user fa-fw"></i> {{Lang::get('menu.UserProfile')}}</a>
                </li>
                <li><a href="{{URL::asset("config")}}"><i class="fa fa-gear fa-fw"></i> {{Lang::get('menu.Settings')}}</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{URL::asset("auth/logout")}}"><i class="fa fa-sign-out fa-fw"></i> {{Lang::get('menu.logout')}}</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        @endif
        <!-- /.dropdown -->
    </ul>
</nav>
