 
<div class="navbar-default sidebar" role="navigation">
    <!-- sidebar nav -->
    <ul class="nav" id="side-menu">
        @if (Auth::check())
        <li><a href="#">{{Lang::get('menu.Operations')}}</a></li>
        <li><a href="#">{{Lang::get('menu.Reports')}}</a></li>
        <li>
            <a href="#">
                <i class="fa fa-gear"></i>{{Lang::get('menu.Settings')}}
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level"> 
                <li><a href="{{URL::to('company')}}">{{Lang::get('menu.Companies')}}</a>
                <li><a href="{{URL::to('person')}}">{{Lang::get('menu.Persons')}}</a>
                </li>
                <li><a href="{{URL::to('modelsensor')}}">{{Lang::get('menu.ModelSensor')}}</a>
            </ul>
            </a>
        </li>
        @else
        <li><a href="{{URL::asset("auth/login")}}">{{Lang::get('menu.Login')}}</a></li>
        
        @endif
        <li><a href="{{URL::asset("contact")}}">{{Lang::get('menu.Contact')}}</a></li>
        <li><a href="{{URL::asset("about")}}">{{Lang::get('menu.About')}}</a></li>
    </ul>
</div>


