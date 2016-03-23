<!doctype html>
<html>
<head>    
	@include('includes.head')
</head>
<body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
            <div class="mdl-layout__header-row">
              @yield('header')
              <div class="mdl-layout-spacer"></div>
              @yield('filter')
              <div class="mdl-layout__obfuscator-right"></div>
            </div>
        </header>
        @include('includes.sidebar')

    <!-- Page Content -->
      <main class="mdl-layout__content mdl-color--grey-100">
        @yield('content')
      </main>
    </div>
    <script>
    @yield('script')
    </script>
  </body>
</html>
