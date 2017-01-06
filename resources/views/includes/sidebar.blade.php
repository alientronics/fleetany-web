<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
    <header class="demo-drawer-header mdl-color--primary">
      <span id="side-lettering">fleetany</span>
      <div class="demo-avatar-dropdown mdl-color-text--accent-contrast">
        <span>{{Auth::user()['name']}}</span>
        <div class="mdl-layout-spacer"></div>
        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
          <i class="material-icons" role="presentation">arrow_drop_down</i>
          <span class="visuallyhidden">Accounts</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
          <li class="mdl-menu__item"></li>
          <a href="{{URL::to('/profile')}}" class="mdl-navigation__link"><li class="mdl-menu__item"><i class="material-icons">person</i>profile</li></a>
          <a href="{{URL::to('/invite')}}" class="mdl-navigation__link"><li class="mdl-menu__item"><i class="material-icons">person</i>invite user</li></a>
          @if (Auth::user()->is('administrator'))
          <a href="{{URL::to('/company/'.Auth::user()["company_id"].'/edit')}}" class="mdl-navigation__link"><li class="mdl-menu__item"><i class="material-icons">domain</i>edit company</li></a>
          @endif
          <a href="{{URL::to('/auth/logout')}}" class="mdl-navigation__link"><li class="mdl-menu__item"><i class="material-icons">exit_to_app</i>log out</li></a>
        </ul>
      </div>
    </header>
    <nav class="demo-navigation mdl-navigation mdl-color--white">
          @if (Auth::check())
            <a class="@if (Request::is('') || Request::is('/')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('/')}}"><i class="material-icons" role="presentation">dashboard</i>{{Lang::get('menu.FleetPanel')}}</a>
            <a class="@if (Request::is('vehicle/fleet/dashboard*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('vehicle/fleet/dashboard')}}"><i class="material-icons" role="presentation">dashboard</i>{{Lang::get('menu.FleetPanel')}}</a>
            @permission('view.company')  
<!--             <a class="@if (Request::is('company*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('company')}}"><i class="material-icons" role="presentation">domain</i>{{Lang::get('menu.Company')}}</a> -->
            @endpermission  
            @permission('view.user') 
            <a class="@if (Request::is('user*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('user')}}"><i class="material-icons" role="presentation">people</i>{{Lang::get('menu.Users')}}</a>
            @endpermission
            @permission('view.fleet')
            <a class="@if (Request::is('fleet*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('fleets')}}"><i class="material-icons" role="presentation">loca_shipping</i>{{Lang::get('menu.Fleet')}}</a>       
            @endpermission  
            @permission('view.vehicle')
            <a class="@if (!Request::is('vehicle/fleet/dashboard*') && Request::is('vehicle*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('vehicle')}}"><i class="material-icons" role="presentation">directions_car</i>{{Lang::get('menu.Vehicles')}}</a>       
            @endpermission
            @permission('view.model')
            <a class="@if (Request::is('model*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('model')}}"><i class="material-icons" role="presentation">layers</i>{{Lang::get('menu.Models')}}</a>       
            @endpermission  
            @permission('view.type')
            <a class="@if (Request::is('type*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('type')}}"><i class="material-icons" role="presentation">local_library</i>{{Lang::get('menu.Types')}}</a>       
            @endpermission  
            @permission('view.contact')
            <a class="@if (Request::is('contact*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('contact')}}"><i class="material-icons" role="presentation">contact_phone</i>{{Lang::get('menu.Contacts')}}</a>       
            @endpermission   
            @permission('view.entry')
            <a class="@if (Request::is('entry*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('entry')}}"><i class="material-icons" role="presentation">event_note</i>{{Lang::get('menu.Entries')}}</a>       
            @endpermission   
            @permission('view.trip')
            <a class="@if (Request::is('trip*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('trip')}}"><i class="material-icons" role="presentation">place</i>{{Lang::get('menu.Trips')}}</a>       
            @endpermission     
            @permission('view.part')
            <a class="@if (Request::is('part*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('part')}}"><i class="material-icons" role="presentation">build</i>{{Lang::get('menu.Parts')}}</a>       
            @endpermission      
            @if (config('app.attributes_api_url') != null)   
              @permission('view.attribute')
              <a class="@if (Request::is('attribute*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('attribute')}}"><i class="material-icons" role="presentation">build</i>{{Lang::get('menu.Attributes')}}</a>       
              @endpermission 
            @endif       
            @permission('view.role')
            <a class="@if (Request::is('role*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="{{URL::to('role')}}"><i class="material-icons" role="presentation">build</i>{{Lang::get('menu.Roles')}}</a>       
            @endpermission  
            @if (class_exists('Alientronics\FleetanyWebReports\Controllers\ReportController'))
            @permission('view.report')
            <a id="submenu-reports-link" class="@if (Request::is('report*')) mdl-color--grey mdl-color-text--white @endif mdl-navigation__link" href="#"><i class="material-icons" role="presentation">assignment</i>{{Lang::get('menu.Reports')}}</a>       
            <!-- sub menu reports -->
            <nav id="submenu-reports" class="mdl-navigation" style="display:none">
             <a href="{{URL::asset("reports/alerts/vehicles")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.VehiclesAlerts')}}</a>
             <a href="{{URL::asset("reports/alerts/tires")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.TiresAlerts')}}</a>
             <a href="{{URL::asset("reports/history/vehicles")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.VehiclesHistory')}}</a>
             <a href="{{URL::asset("reports/vehicles")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.Vehicles')}}</a>
             <a href="{{URL::asset("reports/tires")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.Tires')}}</a>
             <a href="{{URL::asset("reports/sensors")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.Sensors')}}</a>
             <a href="{{URL::asset("reports/vehicles/maintenance")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.VehiclesMaintenance')}}</a>
             <a href="{{URL::asset("reports/tires/maintenance")}}" class="mdl-navigation__link"><i class="material-icons">keyboard_arrow_right</i>{{Lang::get('webreports.TiresMaintenance')}}</a>
            </nav>
        	@endpermission  
            @endif
        @else
        	<a class="mdl-navigation__link" href="{{URL::asset("auth/login")}}"><i class="material-icons" role="presentation">home</i>{{Lang::get('menu.Login')}}</a>
        @endif
    </nav>
    
    
<script>
   $(document).ready(function() {
	 $('#submenu-reports-link').click(function(e) {
	 	$('#submenu-reports').toggle();
	 	$('.demo-drawer').animate({scrollTop: $(document).height()}, 'slow');
	 });
   });
</script>

</div>
