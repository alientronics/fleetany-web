  <dialog class="mdl-dialog">
    <div class="mdl-dialog__content">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('vendor_id')) is-invalid is-dirty @endif"">
            {!!Form::select('vendor_id', [], 1, ['class' => 'mdl-textfield__input'])!!}
   			{!!Form::label('vendor_id', Lang::get('general.vendor'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('vendor_id') }}</span>
        </div>
        
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('part_model_id')) is-invalid is-dirty @endif"">
            {!!Form::select('part_model_id', [], 1, ['id' => 'part_model_id', 'class' => 'mdl-textfield__input'])!!}
   			{!!Form::label('part_model_id', Lang::get('general.part_model'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('part_model_id') }}</span>
        </div>
        
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label @if ($errors->has('part_id')) is-invalid is-dirty @endif"">
            {!!Form::select('part_id', [], 1, ['class' => 'mdl-textfield__input'])!!}
   			{!!Form::label('part_id', Lang::get('general.linked_part'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
        	<span class="mdl-textfield__error">{{ $errors->first('part_id') }}</span>
        </div>
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('cost')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::tel('cost', "", ['id' => 'cost', 'class' => 'mdl-textfield__input mdl-textfield__maskmoney', 'maxlength' => '12'])!!}
			{!!Form::label('cost', Lang::get('general.cost'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('cost') }}</span>
		</div>
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('name')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('name', "", ['class' => 'mdl-textfield__input'])!!}
			{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
		</div>
        
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('number')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('number', "", ['class' => 'mdl-textfield__input'])!!}
			{!!Form::label('number', Lang::get('general.part_number'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('number') }}</span>
		</div>   
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('miliage')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('miliage', "", ['class' => 'mdl-textfield__input'])!!}
			{!!Form::label('miliage', Lang::get('general.miliage'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('miliage') }}</span>
		</div>  
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('position')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::text('position', "", ['class' => 'mdl-textfield__input'])!!}
			{!!Form::label('position', Lang::get('general.position'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('position') }}</span>
		</div> 
		
		<div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('lifecycle')) is-invalid is-dirty @endif"" data-upgraded="eP">
     		{!!Form::number('lifecycle', "", ['class' => 'mdl-textfield__input'])!!}
			{!!Form::label('lifecycle', Lang::get('general.lifecycle'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
			<span class="mdl-textfield__error">{{ $errors->first('lifecycle') }}</span>
		</div> 
    </div>
    <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
      <button type="button" class="mdl-button">Send</button>
      <button type="button" class="mdl-button close">Close</button>
    </div>
  </dialog>

<div class="mdl-grid demo-content">

	<div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
		<div class="mdl-button mdl-button--colored">
	        Vehicle Map
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
		        Tire Position Detail
			</div>
			
			<input id="tire-position-swap-flag" type="hidden" value="0" />
			<input id="tire-position-focus-id" type="hidden" value="0" />
			<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
			
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
		        Tire Storage
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
		    	
    		    	<table class="mdl-data-table mdl-shadow--2dp">
                      <thead>
                        <tr>
                          <th>
                              <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="table-header">
                                <input type="checkbox" id="table-header" class="mdl-checkbox__input" />
                              </label>
                          </th>
                          <th class="mdl-data-table__cell--non-numeric">N&ordm;</th>
                          <th>Brand</th>
                          <th>Mileage</th>
                          <th>Lifecycle</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @foreach($parts as $key => $part)
                        @if($part['part-type'] == Lang::get('setup.tire'))
                        <tr>
                           <td>
                              <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="row[{{++$key}}]">
                                <input type="checkbox" id="row[{{$key}}]" class="mdl-checkbox__input" />
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

	</div>

</div>