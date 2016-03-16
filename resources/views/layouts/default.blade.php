<!doctype html>
<html>
<head>    
	@include('includes.head')
</head>
<body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        @include('includes.header')
        @include('includes.sidebar')

    <!-- Page Content -->
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
        
<!--         	@yield('breadcrumbs', Breadcrumbs::render('home')) -->
        	@if( Session::has('errors') )
                <div class="alert alert-danger" role="alert">
                    <ul>
                    @foreach($errors->all() as $error) 
                    <li>{{$error}}</li>
                    @endforeach
                    </ul>
                </ul>
                </div>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif   
            @if (Session::has('danger'))
                <div class="alert alert-danger">{{ Session::get('danger') }}</div>
            @endif  
            @yield('content')
            
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.1.2/material.min.js"></script>
    <script>
    @yield('script')
    </script>
  </body>
</html>
