@extends('layouts.default')

@section('header')
	@if ($trip->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$trip->type->name}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Trip")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.trip')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.TripData", "view" => "trip.tabs.tripdata"]; /*--}}
@if (config('app.attributes_api_url') != null
		&& !empty($attributes))
	{{--*/ $tabs[] = ["title" => "attributes.Attributes", "view" => "includes.attributes", 'attributes' => $attributes]; /*--}}
@endif

@if (!$trip->id)
{!! Form::open(['route' => 'trip.store']) !!}
@else
{!! Form::model('$trip', [
        'method'=>'PUT',
        'route' => ['trip.update',$trip->id]
    ]) !!}
@endif
            
@include('includes.tabs', [
	'tabs' => $tabs
])
		
{!! Form::close() !!}

		</div>
	</section>
</div>

<script>

	(function() {
	      var x = new mdDateTimePicker({
	        type: 'date',
			future: moment().add(21, 'years')
	      });
	      var y = new mdDateTimePicker({
	        type: 'date',
			future: moment().add(21, 'years')
	      });
	      $('#pickup_date')[0].addEventListener('click', function() {
			x.trigger($('#pickup_date')[0]);
			$('#pickup_date').parent().addClass('is-dirty');
	        x.toggle();
	      });
	      $('#deliver_date')[0].addEventListener('click', function() {
			y.trigger($('#deliver_date')[0]);
			$('#deliver_date').parent().addClass('is-dirty');
	        y.toggle();
	      });
	      // dispatch event test
	      $('#pickup_date')[0].addEventListener('onOk', function() {
	        this.value = x.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
	      });
	      $('#deliver_date')[0].addEventListener('onOk', function() {
        this.value = y.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
      });
    }).call(this);
	    
	$( document ).ready(function() {
		$('#fuel_cost').maskMoney({!!Lang::get("masks.money")!!});
		$('#fuel_amount').maskMoney({!!Lang::get("masks.money")!!});
	});
</script>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop