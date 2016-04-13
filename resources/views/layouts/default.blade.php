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
      <main class="mdl-layout__content mdl-color--grey-300">
        <div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
          <div class="mdl-snackbar__text"></div>
          <button class="mdl-snackbar__action" type="button"></button>
        </div>
        @yield('content')
        @include('includes.footer')
      </main>
    </div>
    @if (Session::has('message')) 
      <script>showSnackBar('{{ Session::get('message') }}')</script>
    @endif 
    @if (Session::has('errors')) 
      <script>showSnackBar('{{ Session::get('errors') }}')</script>
    @endif 
    @if (Session::has('danger')) 
      <script>showSnackBar('{{ Session::get('danger') }}')</script> 
    @endif
  </body>
</html>
