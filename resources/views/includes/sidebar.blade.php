<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
    <header class="demo-drawer-header mdl-color--primary">
      <span id="logo-lettering">fleetany</span>
      <div class="demo-avatar-dropdown">
        <span>{{Auth::user()['name']}}</span>
        <div class="mdl-layout-spacer"></div>
        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
          <i class="material-icons" role="presentation">arrow_drop_down</i>
          <span class="visuallyhidden">Accounts</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
          <li class="mdl-menu__item"></li>
          <li class="mdl-menu__item"><a href="{{URL::to('/profile')}}"><i class="material-icons">person</i>profile</a></li>
          <li class="mdl-menu__item"><a href="{{URL::to('/auth/logout')}}"><i class="material-icons">exit_to_app</i>log out</a></li>
        </ul>
      </div>
    </header>
    <nav class="demo-navigation mdl-navigation mdl-color--white">
          @if (Auth::check())
            <a class="@if (Request::is('') || Request::is('/')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('/')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.FleetPanel')}}</a>
            @permission('view.company')  
            <a class="@if (Request::is('company*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('company')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Company')}}</a>
            @endpermission  
            @permission('view.user') 
            <a class="@if (Request::is('user*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('user')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Users')}}</a>
            @endpermission
            @permission('view.fleet')
            <a class="@if (Request::is('fleet*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('fleets')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Fleet')}}</a>       
            @endpermission  
            @permission('view.vehicle')
            <a class="@if (Request::is('vehicle*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('vehicle')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Vehicles')}}</a>       
            @endpermission
            @permission('view.model')
            <a class="@if (Request::is('model*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('model')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Models')}}</a>       
            @endpermission  
            @permission('view.type')
            <a class="@if (Request::is('type*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('type')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Types')}}</a>       
            @endpermission  
            @permission('view.contact')
            <a class="@if (Request::is('contact*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('contact')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Contacts')}}</a>       
            @endpermission   
            @permission('view.entry')
            <a class="@if (Request::is('entry*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('entry')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Entries')}}</a>       
            @endpermission   
            @permission('view.trip')
            <a class="@if (Request::is('trip*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('trip')}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Trips')}}</a>       
            @endpermission   
        @else
        	<a class="mdl-navigation__link" href="{{URL::asset("auth/login")}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Login')}}</a>
        @endif
    </nav>
</div>
