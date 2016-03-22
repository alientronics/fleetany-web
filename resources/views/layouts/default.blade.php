<!doctype html>
<html>
<head>    
	@include('includes.head')
</head>
<body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        @yield('header')
        @include('includes.sidebar')

    <!-- Page Content -->
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
            @yield('content')
        </div>
      </main>
    </div>
    <script>
    @yield('script')
    </script>
  </body>
</html>
