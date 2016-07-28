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

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.PartData", "view" => "part.tabs.partdata"]; /*--}}
@if (config('app.attributes_api_url') != null
		&& !empty($attributes))
	{{--*/ $tabs[] = ["title" => "attributes.Attributes", "view" => "includes.attributes", 'attributes' => $attributes]; /*--}}
@endif

@if (!$part->id)
{!! Form::open(['route' => 'part.store']) !!}
@else
{!! Form::model('$part', [
        'method'=>'PUT',
        'route' => ['part.update',$part->id]
    ]) !!}
    
    @if(!empty($sensor_data))   
    {{--*/ $tabs[] = ["title" => "general.SensorData", "view" => "part.tabs.showsensors"]; /*--}}
    @endif
    
@endif
     
@include('includes.tabs', [
	'tabs' => $tabs
])

{!! Form::close() !!}

		</div>
	</section>
</div>

<script>
    $(window).bind("load", function() {
    	var page = '{{Request::input("page")}}';
    	if(page) {
            // remove all is-active classes from tabs
            $('a.mdl-tabs__tab').removeClass('is-active');
            // activate desired tab
            $('a[href="#tab1"]').addClass('is-active');
            // remove all is-active classes from panels
            $('.mdl-tabs__panel').removeClass('is-active');
            // activate desired tab panel
            $('#tab1').addClass('is-active');
		}
	});  
      
	$( document ).ready(function() {
		$('#cost').maskMoney({!!Lang::get("masks.money")!!});

		$('#part_type_id').change(function() {
    		$('#part_model_id').empty();
			$('#modeldialog_model_type_id').val($("#part_type_id").val());
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