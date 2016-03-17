<!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('includes.head')
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .mdl-layout {
        	align-items: center;
          justify-content: center;
        }
        .mdl-layout__content {
        	padding: 24px;
        	flex: none;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
