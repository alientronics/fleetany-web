@extends('layouts.default')

@section('header')
	@if ($entry->id)
	{{--*/ $operation = 'update' /*--}}
	<span class="mdl-layout-title">{{$entry->entry_number}}</span>
	@else
	{{--*/ $operation = 'create' /*--}}
	<span class="mdl-layout-title">{{Lang::get("general.Entry")}}</span>
	@endif
@stop

@section('content')

@permission($operation.'.entry')

<div class="">
	<section class="demo-section demo-section--textfield demo-page--textfield mdl-upgraded">
		<div class="demo-preview-block">

@if (!$entry->id)
{!! Form::open(array('route' => 'entry.store')) !!}
@else
{!! Form::model('$entry', [
        'method'=>'PUT',
        'route' => ['entry.update',$entry->id]
    ]) !!}
@endif

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('entry_type_id')) is-invalid is-dirty @endif"">
                {!!Form::select('entry_type_id', $entry_type_id, $entry->entry_type_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('entry_type_id', Lang::get('general.entry_type'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('entry_type_id') }}</span>
            </div>

    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vendor_id')) is-invalid is-dirty @endif"">
                {!!Form::select('vendor_id', $vendor_id, $entry->vendor_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('vendor_id', Lang::get('general.vendor'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('vendor_id') }}</span>
            </div>
            
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vehicle_id')) is-invalid is-dirty @endif"">
                {!!Form::select('vehicle_id', $vehicle_id, $entry->vehicle_id, array('class' => 'mdl-textfield__input'))!!}
       			{!!Form::label('vehicle_id', Lang::get('general.vehicle'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
            	<span class="mdl-textfield__error">{{ $errors->first('vehicle_id') }}</span>
            </div>                        

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('datetime_ini')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('datetime_ini', $entry->datetime_ini, array('id' => 'datetime_ini', 'class' => 'mdl-textfield__input'))!!}
				{!!Form::label('datetime_ini', Lang::get('general.datetime_ini'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('datetime_ini') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('datetime_end')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('datetime_end', $entry->datetime_end, array('id' => 'datetime_end', 'class' => 'mdl-textfield__input'))!!}
				{!!Form::label('datetime_end', Lang::get('general.datetime_end'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('datetime_end') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('entry_number')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::number('entry_number', $entry->entry_number, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('entry_number', Lang::get('general.entry_number'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('entry_number') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('cost', $entry->cost, array('id' => 'cost', 'class' => 'mdl-textfield__input mdl-textfield__maskmoney', 'maxlength' => '12'))!!}
				{!!Form::label('cost', Lang::get('general.cost'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('cost') }}</span>
			</div>

			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('description')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('description', $entry->description, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('description', Lang::get('general.description'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('description') }}</span>
			</div>						

			<div class="mdl-card__actions">
				<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
                  {{ Lang::get('general.Send') }} 
                </button>
			</div>
	
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
      $('#datetime_ini')[0].addEventListener('click', function() {
		x.trigger($('#datetime_ini')[0]);
		$('#datetime_ini').parent().addClass('is-dirty');
        x.toggle();
      });
      $('#datetime_end')[0].addEventListener('click', function() {
		y.trigger($('#datetime_end')[0]);
		$('#datetime_end').parent().addClass('is-dirty');
        y.toggle();
      });
      // dispatch event test
      $('#datetime_ini')[0].addEventListener('onOk', function() {
        this.value = x.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
      });
      $('#datetime_end')[0].addEventListener('onOk', function() {
        this.value = y.time().format('{!!Lang::get("masks.datetimeDatepicker")!!}').toString();
      });
    }).call(this);
		
	$( document ).ready(function() {
		$('#cost').maskMoney({!!Lang::get("masks.money")!!});
		$( "input[name='datetime_ini']" ).mask('{!!Lang::get("masks.datetime")!!}');
		$( "input[name='datetime_end']" ).mask('{!!Lang::get("masks.datetime")!!}');
	});
</script>

@else
<div class="alert alert-info">
	{{Lang::get("general.accessdenied")}}
</div>
@endpermission

@stop