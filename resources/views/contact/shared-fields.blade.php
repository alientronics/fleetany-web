    			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('country')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('country', $contact->country, ['id' => 'country', 'class' => 'mdl-textfield__input immybox immybox_witharrow', 'autocomplete' => 'off'])!!}
                {!!Form::label('country', Lang::get('general.country'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
                <span class="mdl-textfield__error">{{ $errors->first('country') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('state')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('state', $contact->state, ['id' => 'state', 'class' => 'mdl-textfield__input immybox immybox_witharrow', 'autocomplete' => 'off'])!!}
                {!!Form::label('state', Lang::get('general.state'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('state') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('city')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('city', $contact->city, ['id' => 'city', 'class' => 'mdl-textfield__input immybox immybox_witharrow', 'autocomplete' => 'off'])!!}
				{!!Form::label('city', Lang::get('general.city'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('city') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('address')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('address', $contact->address, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('address', Lang::get('general.address'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('address') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('phone')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('phone', $contact->phone, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('phone', Lang::get('general.phone'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('phone') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('license_no')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::number('license_no', $contact->license_no, ['class' => 'mdl-textfield__input'])!!}
				{!!Form::label('license_no', Lang::get('general.license_no'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
				<span class="mdl-textfield__error">{{ $errors->first('license_no') }}</span>
			</div>

<script>
	$( document ).ready(function() {

		var urlCountries = "http://api.geonames.org/countryInfoJSON?username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";
		$.get( urlCountries, function( data ) {
			var countries = [];
			$.each(data.geonames, function (index, country) {
		        item = {}
		        item ["text"] = country.countryName;
		        item ["value"] = country.geonameId;
		        countries.push(item);
			});
			$('#country').immybox({
			    choices: countries
			});
		});

		$(document).off("change","#country").on("change","#country",function() {
			var urlStates = "http://api.geonames.org/childrenJSON?geonameId=" + 
								$(this).val() + 
								"&username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";
			$.get( urlStates, function( data ) {
				var states = [];
				$.each(data.geonames, function (index, state) {
					item = {}
			        item ["text"] = state.toponymName;
			        item ["value"] = state.geonameId;
			        states.push(item);
				});
				$('#state').immybox({
				    choices: states
				});
			});
		});

		$('#state').change(function() {
			var urlCities = "http://api.geonames.org/childrenJSON?geonameId=" + 
								$(this).val() + 
								"&username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";
			$.get( urlCities, function( data ) {
				var cities = [];
				$.each(data.geonames, function (index, city) {
					item = {}
			        item ["text"] = city.toponymName;
			        item ["value"] = city.geonameId;
			        cities.push(item);
				});
				$('#city').immybox({
				    choices: cities
				});
			});
		});
		
	});
</script>
