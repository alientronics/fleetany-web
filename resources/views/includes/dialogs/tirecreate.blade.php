<dialog id="tirecreate-dialog" class="mdl-dialog">
	<h1 class="mdl-dialog__title mdl-color-text--grey-600">{{Lang::get('general.createtire')}}</h1>
    <div class="mdl-dialog__content">
        
    	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('part_model_id')) is-invalid is-dirty @endif"">
            {!!Form::select('part_model_id', $tiresModels, 1, ['id' => 'part_model_id', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('part_model_id', Lang::get('general.part_model'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('part_model_id') }}</span>
        </div>
        
    	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('part_number', "", ['id' => 'part_number', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('part_number', Lang::get('general.fire_number'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    		<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
    	</div>   
    	
    	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('part_miliage', "", ['id' => 'part_miliage', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('part_miliage', Lang::get('general.miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    		<span class="mdl-textfield__error">{{ $errors->first('miliage') }}</span>
    	</div>  
    	
    	<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('lifecycle')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('part_lifecycle', "", ['id' => 'part_lifecycle', 'class' => 'mdl-textfield__input'])!!}
    		{!!Form::label('part_lifecycle', Lang::get('general.lifecycle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    		<span class="mdl-textfield__error">{{ $errors->first('lifecycle') }}</span>
    	</div> 
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button create-tire">{{Lang::get('general.Submit')}}</button>
      <button type="button" class="mdl-button close-tire">{{Lang::get('general.Close')}}</button>
    </div>
</dialog>