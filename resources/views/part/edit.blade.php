@extends('layouts.default')

@section('header')
	@if ($part->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$part->number}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Part")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.part')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$part->id)
{!! Form::open(['route' => 'part.store']) !!}
@else
{!! Form::model('$part', [
        'method'=>'PUT',
        'route' => ['part.update',$part->id]
    ]) !!}
@endif
     
    @if(!empty($sensor_data))      
    	@include('includes.tabs', [
        	'tabs' => [
                ["title" => "general.PartData", "view" => "part.tabs.partdata"], 
                ["title" => "general.SensorData", "view" => "part.tabs.showsensors"], 
        	]
        ])
    @else
    	@include('includes.tabs', [
        	'tabs' => [
                ["title" => "general.PartData", "view" => "part.tabs.partdata"], 
        	]
        ])
    @endif
    
{!! Form::close() !!}

		</div>
	</section>
</div>

<script>
	$( document ).ready(function() {
		$('#cost').maskMoney({!!Lang::get("masks.money")!!});

		$('#part_type_id').change(function() {
    		$('#part_model_id').empty();
            $.get(url('getModels/part/'+$("#part_type_id").val()), function(retorno) {
        		$.each(JSON.parse(retorno), function (i, value) {
					console.log(i + ' - ' + value);
            		$('#part_model_id').append($('<option>', {
                	    value: i,
                	    text: value
                	}));
                });     
        	});   
    	});
	});
</script>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop