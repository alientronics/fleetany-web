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

{{--*/ $tabs = []; /*--}}
{{--*/ $tabs[] = ["title" => "general.EntryData", "view" => "entry.tabs.entrydata"]; /*--}}
@if (config('app.attributes_api_url') != null
		&& !empty($attributes))
	{{--*/ $tabs[] = ["title" => "attributes.Attributes", "view" => "includes.attributes", 'attributes' => $attributes]; /*--}}
@endif

@if (!$entry->id)
{!! Form::open(['route' => 'entry.store']) !!}
@else
{!! Form::model('$entry', [
        'method'=>'PUT',
        'route' => ['entry.update',$entry->id]
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

		$('#vehicle_id').change(function() {
    		$('.div_entry_parts').empty();

            $.get(url('getPartsByVehicle/'+$("#vehicle_id").val()), function(retorno) {

				var parts = "";
        
        		$.each(retorno, function (i, part) {
					parts += '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="part'+part.id+'">'+
                      '<input name="parts[]" type="checkbox" id="part'+part.id+'" class="mdl-checkbox__input" value="'+part.id+'" />'+
                      '<span class="mdl-checkbox__label">'+part.name+'</span>'+
                    '</label>';
                }); 

				if(parts.length > 0) {
					$(".div_entry_parts").html(
						'<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label "" data-upgraded="eP">'+
						parts +
                		'{!!Form::label("parts", Lang::get("general.Parts"), ["class" => "mdl-color-text--primary-contrast mdl-textfield__label is-dirty"])!!}'+
                    	'<span class="mdl-textfield__error"></span>'+
                    '</div>');
					componentHandler.upgradeDom();
				}
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