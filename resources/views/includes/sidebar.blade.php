<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
    <header class="demo-drawer-header mdl-color--primary">
      <span id="logo-lettering">fleetany</span>
      <div class="demo-avatar-dropdown">
        <span>hello@example.com</span>
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
    <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          @if (Auth::check())
            <a class="mdl-navigation__link" href="{{URL::to('/')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.FleetPanel')}}</a>
            @permission('view.company')  
            <a class="mdl-navigation__link" href="{{URL::to('company')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Company')}}</a>
            @endpermission  
            @permission('view.user') 
            <a class="mdl-navigation__link" href="{{URL::to('user')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Users')}}</a>
            @endpermission
            @permission('view.fleet')
            <a class="mdl-navigation__link" href="{{URL::to('fleets')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Fleet')}}</a>       
            @endpermission  
            @permission('view.vehicle')
            <a class="mdl-navigation__link" href="{{URL::to('vehicle')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Vehicles')}}</a>       
            @endpermission
            @permission('view.model')
            <a class="mdl-navigation__link" href="{{URL::to('model')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Models')}}</a>       
            @endpermission  
            @permission('view.type')
            <a class="mdl-navigation__link" href="{{URL::to('type')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Types')}}</a>       
            @endpermission  
            @permission('view.contact')
            <a class="mdl-navigation__link" href="{{URL::to('contact')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Contacts')}}</a>       
            @endpermission   
            @permission('view.entry')
            <a class="mdl-navigation__link" href="{{URL::to('entry')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Entries')}}</a>       
            @endpermission   
            @permission('view.trip')
            <a class="mdl-navigation__link" href="{{URL::to('trip')}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Trips')}}</a>       
            @endpermission   
        @else
        	<a class="mdl-navigation__link" href="{{URL::asset("auth/login")}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Login')}}</a>
        @endif
        <a class="mdl-navigation__link" href="{{URL::asset("contact")}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.Contact')}}</a>
        <a class="mdl-navigation__link" href="{{URL::asset("about")}}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>{{Lang::get('menu.About')}}</a>
      
      <div class="mdl-layout-spacer"></div>
      <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
    </nav>
</div>
