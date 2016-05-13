    			
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


		function fillCountries(data) {
			var countries = [];
			var countryVal = $('#country').val();
			$.each(data.geonames, function (index, country) {
		        item = {}
		        item ["text"] = country.countryName;
		        item ["value"] = country.countryCode;
		        countries.push(item);
			});
			$('#country').immybox({
			    choices: countries
			});
			$('#country').val(countryVal);
		};

		$('#country').on('keyup', function(){

			if($('#country').val().length < 3) {
				return;
			}

			var urlCountries = "http://api.geonames.org/searchJSON?name_startsWith="+
                        		$('#country').val()+'&fcode=pcli'+
                    			"&username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";

    		$.ajax({
    		    url: urlCountries,
    		    type: 'GET',
    		    crossDomain: true,
    		    dataType: 'jsonp',
    		    success: fillCountries,
    		    error: function() { console.log('Failed!'); }
    		});
		});
		
		function fillStates(data){
			var states = [];
			var stateVal = $('#state').val();
			$.each(data.geonames, function (index, state) {
				item = {}
		        item ["text"] = state.toponymName;
		        item ["value"] = state.name;
		        states.push(item);
			});
			$('#state').immybox({
			    choices: states
			});
			$('#state').val(stateVal);
		}

		$('#state').on('keyup', function(){

			if($('#state').val().length < 3) {
				return;
			}

			var urlStates = "http://api.geonames.org/searchJSON?name_startsWith="+
								encodeURIComponent($('#state').val())+
								'&country='+$('#country').immybox('getValue')+
								'&fcode=ADM1'+
                    			"&username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";

    		$.ajax({
    		    url: urlStates,
    		    type: 'GET',
    		    crossDomain: true,
    		    dataType: 'jsonp',
    		    success: fillStates,
    		    error: function() { console.log('Failed!'); }
    		});
		});

		function fillCities(data){
			var cities = [];
			var cityVal = $('#city').val();
			$.each(data.geonames, function (index, city) {
				item = {}
		        item ["text"] = city.toponymName;
		        item ["value"] = city.geonameId;
		        cities.push(item);
			});
			$('#city').immybox({
			    choices: cities
			});
			$('#city').val(cityVal);
		}

		$('#city').on('keyup', function(){

			if($('#city').val().length < 3) {
				return;
			}

			var urlCities = "http://api.geonames.org/searchJSON?q="+encodeURIComponent($('#state').immybox('getValue'))+
                        		"&name_startsWith="+encodeURIComponent($('#city').val())+
                        		'&country='+encodeURIComponent($('#country').immybox('getValue'))+
                        		'&fcode=ADM2'+
                    			"&username={{config('app.geonames_username')}}&lang={!!Lang::get('masks.geoname')!!}";

    		$.ajax({
    		    url: urlCities,
    		    type: 'GET',
    		    crossDomain: true,
    		    dataType: 'jsonp',
    		    success: fillCities,
    		    error: function() { console.log('Failed!'); }
    		});
		});

	});
</script>
