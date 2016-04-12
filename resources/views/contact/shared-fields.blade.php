			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('country')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('country', $contact->country, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('country', Lang::get('general.country'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('country') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('state')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('state', $contact->state, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('state', Lang::get('general.state'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('state') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('city')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('city', $contact->city, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('city', Lang::get('general.city'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('city') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('address')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::text('address', $contact->address, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('address', Lang::get('general.address'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('address') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('phone')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::tel('phone', $contact->phone, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('phone', Lang::get('general.phone'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('phone') }}</span>
			</div>
			
			<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('license_no')) is-invalid is-dirty @endif"" data-upgraded="eP">
         		{!!Form::number('license_no', $contact->license_no, array('class' => 'mdl-textfield__input'))!!}
				{!!Form::label('license_no', Lang::get('general.license_no'), array('class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'))!!}
				<span class="mdl-textfield__error">{{ $errors->first('license_no') }}</span>
			</div>
