<dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
        
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('modeldialog_model_type_id')) is-invalid is-dirty @endif"">
            {!!Form::select('modeldialog_model_type_id', $modeldialog['model_types'], 1, ['id' => 'modeldialog_model_type_id', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('modeldialog_model_type_id', Lang::get('general.model_type'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('modeldialog_model_type_id') }}</span>
        </div>
        
    	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('modeldialog_vendor_id')) is-invalid is-dirty @endif"">
            {!!Form::select('modeldialog_vendor_id', $modeldialog['vendors'], 1, ['id' => 'modeldialog_vendor_id', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('modeldialog_vendor_id', Lang::get('general.vendor'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('modeldialog_vendor_id') }}</span>
        </div>                        
    	
    	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('modeldialog_name')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('modeldialog_name', "", ['id' => 'modeldialog_name', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('modeldialog_name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    		<span class="mdl-textfield__error">{{ $errors->first('modeldialog_name') }}</span>
    	</div>  
    	
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button create-model">{{Lang::get('general.Submit')}}</button>
      <button type="button" class="mdl-button close">{{Lang::get('general.Close')}}</button>
    </div>
</dialog>