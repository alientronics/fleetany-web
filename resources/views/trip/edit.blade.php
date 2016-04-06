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

@if (!$trip->id)
{!! Form::open(array('route' => 'trip.store')) !!}
@else
{!! Form::model('$trip', [
        'method'=>'PUT',
        'route' => ['trip.update',$trip->id]
    ]) !!}
@endif
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('driver_id')) is-invalid is-dirty @endif"">
                {!!Form::select('driver_id', $driver_id, $trip->driver_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('driver_id', Lang::get('general.driver'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('driver_id') }}</span>
            </div>
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vehicle_id')) is-invalid is-dirty @endif"">
                {!!Form::select('vehicle_id', $vehicle_id, $trip->vehicle_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('vehicle_id', Lang::get('general.vehicle'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('vehicle_id') }}</span>
            </div>
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vendor_id')) is-invalid is-dirty @endif"">
                {!!Form::select('vendor_id', $vendor_id, $trip->vendor_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('vendor_id', Lang::get('general.vendor'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('vendor_id') }}</span>
            </div>
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('trip_type_id')) is-invalid is-dirty @endif"">
                {!!Form::select('trip_type_id', $trip_type_id, $trip->trip_type_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('trip_type_id', Lang::get('general.trip_type'), array('class' => 'mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('trip_type_id') }}</span>
            </div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('pickup_date')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('pickup_date', $trip->pickup_date, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('pickup_date', Lang::get('general.pickup_date'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('pickup_date') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('deliver_date')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('deliver_date', $trip->deliver_date, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('deliver_date', Lang::get('general.deliver_date'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('deliver_date') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('pickup_place')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('pickup_place', $trip->pickup_place, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('pickup_place', Lang::get('general.pickup_place'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('pickup_place') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('deliver_place')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('deliver_place', $trip->deliver_place, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('deliver_place', Lang::get('general.deliver_place'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('deliver_place') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('begin_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('begin_mileage', $trip->begin_mileage, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('begin_mileage', Lang::get('general.begin_mileage'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('begin_mileage') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('end_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('end_mileage', $trip->end_mileage, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('end_mileage', Lang::get('general.end_mileage'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('end_mileage') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('total_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('total_mileage', $trip->total_mileage, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('total_mileage', Lang::get('general.total_mileage'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('total_mileage') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('fuel_cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('fuel_cost', $trip->fuel_cost, array('id' => 'fuel_cost', 'class' => 'mdl-textfield__input'))!!}
				{!!Form::label('fuel_cost', Lang::get('general.fuel_cost'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('fuel_cost') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('fuel_amount')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('fuel_amount', $trip->fuel_amount, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('fuel_amount', Lang::get('general.fuel_amount'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('fuel_amount') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('description')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('description', $trip->description, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('description', Lang::get('general.description'), array('class' => 'mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('description') }}</span>
			</div>

			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored">
                  {{ Lang::get('general.Send') }} 
                </button>
			</div>
		
{!! Form::close() !!}

		</div>
	</section>
</div>

<script>
	$( document ).ready(function() {
		$('#fuel_cost').maskMoney({!!Lang::get("masks.money")!!});

        var x = new mdDateTimePicker({
            type: 'date'
        });

		$( "input[name='pickup_date']" ).click(function() {
			x.toggle();
		});

		$( "#mddtp-date__ok" ).click(function() {
			var date = new Date(x.time());
			date = moment(date, "YYYY-MM-DD HH:mm:ss");
		
			$( "input[name='pickup_date']" ).val(x.time().toString());
    	});
    	
	});
</script>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop