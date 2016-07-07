@include('includes.dialogs.typecreate')

	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('model_type_id')) is-invalid is-dirty @endif"">
        {!!Form::select('model_type_id', $model_type_id, $model->model_type_id, ['class' => 'mdl-textfield__input'])!!}
        <i id="type-add" class="material-icons">add_circle_outline</i>
		{!!Form::label('model_type_id', Lang::get('general.model_type'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('model_type_id') }}</span>
    </div>
    
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vendor_id')) is-invalid is-dirty @endif"">
        {!!Form::select('vendor_id', $vendor_id, $model->vendor_id, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('vendor_id', Lang::get('general.vendor'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('vendor_id') }}</span>
    </div>                        
	
	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
 		{!!Form::text('name', $model->name, ['class' => 'mdl-textfield__input'])!!}
		{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
		<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
	</div>                       
	
	<div class="mdl-card__actions">
		<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
	</div>