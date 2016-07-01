  <dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
        
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('part_model_id')) is-invalid is-dirty @endif"">
            {!!Form::select('part_model_id', $tiresModels, 1, ['id' => 'part_model_id', 'class' => 'mdl-textfield__input'])!!}
   			{!!Form::label('part_model_id', Lang::get('general.part_model'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('part_model_id') }}</span>
        </div>
        
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('number', "", ['id' => 'part_number', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('number', Lang::get('general.part_number'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
		</div>   
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('miliage', "", ['id' => 'part_miliage', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('miliage', Lang::get('general.miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('miliage') }}</span>
		</div>  
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('lifecycle')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('lifecycle', "", ['id' => 'part_lifecycle', 'class' => 'mdl-textfield__input'])!!}
			{!!Form::label('lifecycle', Lang::get('general.lifecycle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('lifecycle') }}</span>
		</div> 
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button create-tire">{{Lang::get('general.Submit')}}</button>
      <button type="button" class="mdl-button close">{{Lang::get('general.Close')}}</button>
    </div>
  </dialog>

<div class="mdl-grid demo-content">

	<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
		<div class="mdl-button mdl-button--colored">
	        {{Lang::get('general.VehicleMap')}}
		</div>
		
		<div class="mdl-card__actions mdl-card--border"></div>
	    <div class="mdl-card__supporting-text" style="height: 500px;">
	    	<div class="mdl-color-text--grey tires-front">
	    		<span>(</span>
	    	</div>
	    	<div class="mdl-grid" style="height: 100px;">
		    	<div class="mdl-cell mdl-cell--1-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos1" class="@if(!empty($tiresPositions[1])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos2" class="@if(!empty($tiresPositions[2])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div class="mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos3" class="@if(!empty($tiresPositions[3])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos4" class="@if(!empty($tiresPositions[4])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
	    	</div>
	    	<div class="mdl-grid" style="height: 100px;">
		    	<div class="mdl-cell mdl-cell--1-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos5" class="@if(!empty($tiresPositions[5])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos6" class="@if(!empty($tiresPositions[6])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div class="mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos7" class="@if(!empty($tiresPositions[7])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos8" class="@if(!empty($tiresPositions[8])) mdl-color--green tires-filled @else mdl-color--grey tires-empty @endif mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
	    	</div>
	    	<div class="mdl-color-text--grey tires-back">
	    		<span>]</span>
	    	</div>
	    </div>
	</div>

	<div class="mdl-cell mdl-cell--6-col mdl-grid mdl-grid--no-spacing">

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TirePositionDetail')}}
			</div>
			
			<input id="tire-position-swap-flag" type="hidden" value="0" />
			<input id="tire-position-focus-id" type="hidden" value="0" />
			<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
			<input id="part-type-id" type="hidden" value="{{$part_type_id}}" />
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-position-detail" style="height: 200px;">
		    	<div id="tire-position-detail-data"></div>
                	
                <div class="tires-buttons-bottom">	    	
                	<button id="tire-position-swap" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary tire-position-detail-button">
                      <i class="material-icons">swap_horiz</i>
                    </button>
                    <button id="tire-position-remove" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary tire-position-detail-button">
                      <i class="material-icons">arrow_downward</i>
                    </button>
		    	</div>
		    </div>
		</div>

		<div class="mdl-cell--1-col" style="height: 32px;"></div>

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TireStorage')}}
			</div>
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-storage">
                <div class="tires-buttons-top">	   
                    <button id="tire-add" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
                      <i class="material-icons">add</i>
                    </button>
                    <button id="tire-position-add" class="mdl-cell--hide-tablet mdl-cell--hide-phone mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
                      <i class="material-icons">arrow_upward</i>
                    </button>
                </div>
		    	<div id="tire-storage-data">
		    	
    		    	<table class="mdl-data-table mdl-shadow--2dp" style="width:102%; margin-left:-10px;">
                      <thead>
                        <tr>
                          <th></th>
                          <th class="mdl-data-table__cell--non-numeric">{{Lang::get('general.number')}}</th>
                          <th>{{Lang::get('general.Model')}}</th>
                          <th>{{Lang::get('general.miliage')}}</th>
                          <th>{{Lang::get('general.lifecycle')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @foreach($parts as $key => $part)
                        @if($part['part-type'] == Lang::get('setup.tire') && $part['position'] == 0)
                        <tr>
                           <td>
                              <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect mdl-data-table__select" for="row[{{++$key}}]">
                                <input type="radio" id="row[{{$key}}]" class="mdl-radio__button" name="tire-storage-id" value="{{$part['id']}}" />
                              </label>
                          </td>
                          <td class="mdl-data-table__cell--non-numeric">{{$part['number']}}</td>
                          <td>{{$part['tire-model']}}</td>
                          <td>{{$part['miliage']}}</td>
                          <td>{{$part['lifecycle']}}</td>
                        </tr>
                        @endif
                      @endforeach
                      </tbody>
                    </table>
		    	
		    	</div>
		    	
		    </div>
		</div>
		
		<div class="mdl-cell--1-col" style="height: 32px;"></div>

		<div class="mdl-card mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-button mdl-button--colored">
		        {{Lang::get('general.TireStorageDetail')}}
			</div>
			
			<div class="mdl-card__actions mdl-card--border"></div>
		    <div id="tire-storage-detail">
		    	<div id="tire-storage-detail-data"></div>
		    </div>
		</div>

	</div>

</div>
