<!doctype html>
<html>
<head>    
	@include('includes.head')
</head>
<body>
    <div id="wrapper">
        @include('includes.header')
        @include('includes.sidebar')

    <!-- Page Content -->
    <div id="page-wrapper">
        @yield('breadcrumbs', Breadcrumbs::render('home'))
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield("titles")
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
            @yield('content')
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

  
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{URL::asset('js/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{URL::asset('js/sb-admin-2.js')}}"></script>
    <script src="{{ asset ("/js/falkermap.js") }}" type="text/javascript"></script>
    <script>
    @yield('script')
    </script>
</body>
</html>
