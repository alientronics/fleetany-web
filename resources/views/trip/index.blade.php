@extends('layouts.default')

@section('header')
      
      <span class="mdl-layout-title">{{Lang::get("general.Trip")}}</span>

@stop

@permission('view.trip')  

@include('trip.filter')

@section('content')

<div class="mdl-grid demo-content">

    @include('includes.gridview')
     
</div>

@stop

@endpermission