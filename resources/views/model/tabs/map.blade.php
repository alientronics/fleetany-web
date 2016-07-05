	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('map')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('map', $model->map, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('map', Lang::get('general.Map'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('map') }}</span>
	</div>

	<div class="mdl-card__actions">
		<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
	</div>