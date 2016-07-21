<dialog id="typecreate-dialog" class="mdl-dialog">
	<h1 class="mdl-dialog__title mdl-color-text--grey-600">{{Lang::get('general.createtype')}}</h1>
    <div class="mdl-dialog__content">
        
        <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('typedialog_name')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('typedialog_name', "", ['id' => 'typedialog_name', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('typedialog_name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('typedialog_name') }}</span>
		</div>

		@if(empty($typedialog['entity_key']))
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('typedialog_entity_key')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('typedialog_entity_key', "", ['id' => 'typedialog_entity_key', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('typedialog_entity_key', Lang::get('general.entity_key'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('typedialog_entity_key') }}</span>
		</div>
		@else
		{!!Form::hidden('typedialog_entity_key', $typedialog['entity_key'], ['id' => 'typedialog_entity_key'])!!}
		@endif
    	
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button create-type">{{Lang::get('general.Submit')}}</button>
      <button type="button" class="mdl-button close-type">{{Lang::get('general.Close')}}</button>
    </div>
</dialog>