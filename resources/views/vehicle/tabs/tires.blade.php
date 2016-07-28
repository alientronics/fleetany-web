@include('includes.dialogs.tirecreate', [
	'tiresModels' => $tiresModels
])

<div class="mdl-grid demo-content">

    @include('vehicle.map.map', [
    	'vehicle' => $vehicle,
    	'tiresPositions' => $tiresPositions
    ])

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
		    	
    		    	@include('vehicle.tabs.tiresstorage', [
                    	'tires' => $tires
                    ])
		    	
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
