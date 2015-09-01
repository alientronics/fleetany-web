

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-th-list"></i> @yield('sub-title')
                            <div class="pull-right">
                                @yield('actions')
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class='table-responsive'>
                                @yield('table')
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
@stop