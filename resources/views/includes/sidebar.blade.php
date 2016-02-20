 
<div class="navbar-default sidebar" permission="navigation">
    <!-- sidebar nav -->
    <ul class="nav" id="side-menu">
        @if (Auth::check())
        <li><a href="{{URL::to('/')}}">{{Lang::get('menu.FleetPanel')}}</a></li>
        @permission('view.company')  
        <li><a href="{{URL::to('company')}}">{{Lang::get('menu.Company')}}</a></li>
        @endpermission  
        @permission('view.user') 
        <li><a href="{{URL::to('user')}}">{{Lang::get('menu.Users')}}</a></li>
        @endpermission
        @permission('view.modelmonitor') 
        <li><a href="{{URL::to('modelmonitor')}}">{{Lang::get('menu.Monitors')}}</a></li>
        @endpermission
        @permission('view.modelvehicle')
        <li><a href="{{URL::to('modelvehicle')}}">{{Lang::get('menu.Vehicles')}}</a></li> 
        @endpermission               
        @permission('view.fleet')
        <li><a href="{{URL::to('fleets')}}">{{Lang::get('menu.Fleet')}}</a></li>       
        @endpermission   
        <li>
            <a href="#">
                {{Lang::get('menu.Reports')}}
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
        		@permission('view.modelvehicle') 
                <li><a href="{{URL::to('report')}}">{{Lang::get('menu.Vehicle')}}</a></li>
                @endpermission
        		@permission('view.modeltire') 
                <li><a href="{{URL::to('report')}}">{{Lang::get('menu.Tires')}}</a></li>
                @endpermission
        		@permission('view.maintenance') 
                <li><a href="{{URL::to('report')}}">{{Lang::get('menu.Maintenance')}}</a></li>
                @endpermission
        		@permission('view.efficiency') 
                <li><a href="{{URL::to('report')}}">{{Lang::get('menu.Efficiency')}}</a></li>
                @endpermission
            </ul>           
        </li>
        <li>
            <a href="#">
                {{Lang::get('menu.AuxiliarTables')}}
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level"> 
        		@permission('view.plantype') 
                <li><a href="{{URL::to('company')}}">{{Lang::get('menu.PlanType')}}</a></li>
            	@endpermission
        		@permission('view.userprofile')
                <li><a href="{{URL::to('person')}}">{{Lang::get('menu.UserProfile')}}</a></li>
            	@endpermission
        		@permission('view.modelvehicle')
                <li><a href="{{URL::to('modelvehicle')}}">{{Lang::get('menu.ModelVehicle')}}</a></li>
            	@endpermission
        		@permission('view.modelmonitor')
                <li><a href="{{URL::to('modelmonitor')}}">{{Lang::get('menu.ModelMonitor')}}</a></li>
            	@endpermission
        		@permission('view.modelsensor')
                <li><a href="{{URL::to('modelsensor')}}">{{Lang::get('menu.ModelSensor')}}</a></li>
            	@endpermission
        		@permission('view.modeltire')
                <li><a href="{{URL::to('modeltire')}}">{{Lang::get('menu.ModelTire')}}</a></li>
            	@endpermission
        		@permission('view.typevehicle')
                <li><a href="{{URL::to('typevehicle')}}">{{Lang::get('menu.TypeVehicle')}}</a></li>
            	@endpermission
            </ul>
        </li>
        @else
        <li><a href="{{URL::asset("auth/login")}}">{{Lang::get('menu.Login')}}</a></li>
        
        @endif
        <li><a href="{{URL::asset("contact")}}">{{Lang::get('menu.Contact')}}</a></li>
        <li><a href="{{URL::asset("about")}}">{{Lang::get('menu.About')}}</a></li>
    </ul>
</div>


