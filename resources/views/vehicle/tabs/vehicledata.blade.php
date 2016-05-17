    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('model_vehicle_id')) is-invalid is-dirty @endif"">
        {!!Form::select('model_vehicle_id', $model_vehicle_id, $vehicle->model_vehicle_id, ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('model_vehicle_id', Lang::get('general.model_vehicle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('model_vehicle_id') }}</span>
    </div>
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::text('number', $vehicle->number, ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('number', Lang::get('general.number'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
    </div>    
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('initial_miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::number('initial_miliage', $vehicle->initial_miliage, ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('initial_miliage', Lang::get('general.initial_miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('initial_miliage') }}</span>
    </div>  
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('actual_miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::number('actual_miliage', $vehicle->actual_miliage, ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('actual_miliage', Lang::get('general.actual_miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('actual_miliage') }}</span>
    </div>  
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::tel('cost', $vehicle->cost, ['id' => 'cost', 'class' => 'mdl-textfield__input mdl-textfield__maskmoney'])!!}
    	{!!Form::label('cost', Lang::get('general.cost'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('cost') }}</span>
    </div>  
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('description')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::text('description', $vehicle->description, ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('description', Lang::get('general.description'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('description') }}</span>
    </div>  			
    
    <div class="mdl-card__actions">
    	<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
    </div>