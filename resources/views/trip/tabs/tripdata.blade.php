@include('includes.dialogs.typecreate', [
	'typedialog' => $typedialog
])

	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('driver_id')) is-invalid is-dirty @endif"">
        {!!Form::select('driver_id', $driver_id, $trip->driver_id, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('driver_id', Lang::get('general.driver'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('driver_id') }}</span>
    </div>
    
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vehicle_id')) is-invalid is-dirty @endif"">
        {!!Form::select('vehicle_id', $vehicle_id, $trip->vehicle_id, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('vehicle_id', Lang::get('general.vehicle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('vehicle_id') }}</span>
    </div>
    
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vendor_id')) is-invalid is-dirty @endif"">
        {!!Form::select('vendor_id', $vendor_id, $trip->vendor_id, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('vendor_id', Lang::get('general.vendor'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('vendor_id') }}</span>
    </div>
    
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('trip_type_id')) is-invalid is-dirty @endif"">
        {!!Form::select('trip_type_id', $trip_type_id, $trip->trip_type_id, ['class' => 'mdl-textfield__input dialog-add-item-combobox'])!!}
		<i id="type-add" class="material-icons dialog-add-item-button">add_circle_outline</i>
		{!!Form::label('trip_type_id', Lang::get('general.trip_type'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('trip_type_id') }}</span>
    </div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('pickup_date')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('pickup_date', $trip->pickup_date, ['id' => 'pickup_date', 'class' => 'mdl-textfield__input'])!!}
		{!!Form::label('pickup_date', Lang::get('general.pickup_date'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('pickup_date') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('deliver_date')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('deliver_date', $trip->deliver_date, ['id' => 'deliver_date', 'class' => 'mdl-textfield__input'])!!}
		{!!Form::label('deliver_date', Lang::get('general.deliver_date'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('deliver_date') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('pickup_place')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('pickup_place', $trip->pickup_place, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('pickup_place', Lang::get('general.pickup_place'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('pickup_place') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('deliver_place')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('deliver_place', $trip->deliver_place, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('deliver_place', Lang::get('general.deliver_place'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('deliver_place') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('begin_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::number('begin_mileage', $trip->begin_mileage, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('begin_mileage', Lang::get('general.begin_mileage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('begin_mileage') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('end_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::number('end_mileage', $trip->end_mileage, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('end_mileage', Lang::get('general.end_mileage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('end_mileage') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('total_mileage')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::number('total_mileage', $trip->total_mileage, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('total_mileage', Lang::get('general.total_mileage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('total_mileage') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('fuel_cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::tel('fuel_cost', $trip->fuel_cost, ['id' => 'fuel_cost', 'class' => 'mdl-textfield__input mdl-textfield__maskmoney', 'maxlength' => '12'])!!}
		{!!Form::label('fuel_cost', Lang::get('general.fuel_cost'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('fuel_cost') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('fuel_amount')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::tel('fuel_amount', $trip->fuel_amount, ['id' => 'fuel_amount', 'class' => 'mdl-textfield__input mdl-textfield__maskmoney'])!!}
		{!!Form::label('fuel_amount', Lang::get('general.fuel_amount'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('fuel_amount') }}</span>
	</div>
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('description')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('description', $trip->description, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('description', Lang::get('general.description'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('description') }}</span>
	</div>
    
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('fuel_type')) is-invalid is-dirty @endif"">
        {!!Form::select('fuel_type', $fuel_type, $trip->fuel_type, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('fuel_type', Lang::get('general.fuel_type'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('fuel_type') }}</span>
    </div>

	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('tank_fill_up')) is-invalid is-dirty @endif"">
        {!!Form::select('tank_fill_up', [Lang::get('general.No'), Lang::get('general.Yes')], $trip->tank_fill_up, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('tank_fill_up', Lang::get('general.tank_fill_up'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('tank_fill_up') }}</span>
    </div>
    
	<div class="mdl-card__actions">
		<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
	</div>