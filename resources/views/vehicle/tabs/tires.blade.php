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
		    	<div id="pos1" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
		    	<div id="pos2" class="mdl-color--green mdl-cell mdl-cell--2-col tires-filled">
		    		&nbsp;
		    	</div>
		    	<div class="mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos3" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
		    	<div id="pos4" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
	    	</div>
	    	<div class="mdl-grid" style="height: 100px;">
		    	<div class="mdl-cell mdl-cell--1-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos5" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
		    	<div id="pos6" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
		    	<div class="mdl-cell mdl-cell--2-col">
		    		&nbsp;
		    	</div>
		    	<div id="pos7" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
		    		&nbsp;
		    	</div>
		    	<div id="pos8" class="mdl-color--grey mdl-cell mdl-cell--2-col tires-empty">
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
		    	
    		    	<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                      <thead>
                        <tr>
                          <th class="mdl-data-table__cell--non-numeric">Nº</th>
                          <th>Brand</th>
                          <th>Mileage</th>
                          <th>Lifecycle</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="mdl-data-table__cell--non-numeric">Acrylic (Transparent)</td>
                          <td>25</td>
                          <td>$2.90</td>
                          <td>$2.90</td>
                        </tr>
                        <tr>
                          <td class="mdl-data-table__cell--non-numeric">Plywood (Birch)</td>
                          <td>50</td>
                          <td>$1.25</td>
                          <td>$1.25</td>
                        </tr>
                        <tr>
                          <td class="mdl-data-table__cell--non-numeric">Laminate (Gold on Blue)</td>
                          <td>10</td>
                          <td>$2.35</td>
                          <td>$2.35</td>
                        </tr>
                      </tbody>
                    </table>
		    	
		    	</div>
		    	
		    </div>
		</div>

	</div>

</div>