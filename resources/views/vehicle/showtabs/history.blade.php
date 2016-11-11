<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div class="mdl-grid demo-content">

	<input id="vehicle-id" type="hidden" value="{{$vehicle->id}}" />
	<input type="hidden" name="tire-position-focus-id" id="tire-position-focus-id" />
	
    <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
    	<a href="{{url('/')}}/vehicle/{{$vehicle->id}}/edit">
        	<div class="mdl-button mdl-button--colored">
                {{Lang::get("general.fleet_number")}}: {{$vehicle->fleet}} - {{Lang::get("general.number")}}: {{$vehicle->number}}
        	</div>
    	</a>
    	
    	<input type="hidden" id="updateDatetime" value='{{date("Y-m-d H:i:s")}}' />
    	
    	<div class="mdl-card__actions mdl-card--border"></div>
        <div class="mdl-card__supporting-text">
    	
    	@if(!empty(str_split($vehicle->model->map)))
    		{{--*/ 
    			$col = 0; 
    			$final = false;
    			$modelMapTractor = substr($vehicle->model->map, 0, 16);
    			$modelMapTrailer = substr($vehicle->model->map, 33);
    			$lastTireModelMap = $lastTiremodelMapTractor = strripos($modelMapTractor,'1') + 1;
    			$lastTiremodelMapTrailer = strripos($vehicle->model->map,'1') + 1;
    		/*--}}
    
    		@if(strpos($modelMapTractor, '1') !== false)
            	<div class="mdl-color-text--grey tires-front">
            		<span>(</span>
            	</div>
        	@endif
    		
    		@foreach(str_split($vehicle->model->map) as $key => $value)
    
    			@if($key == 16 && strpos($modelMapTrailer, '1') !== false)
    				@if(strpos($modelMapTractor, '1') !== false)
            	    	<div class="mdl-color-text--grey tires-back">
            	    		<span>]</span>
            	    	</div>
        	    	@endif
        	    	<div class="mdl-color-text--grey tires-back">
        	    		<span>[</span>
        	    	</div>
        			{{--*/ 
        				$final = false; 
        				$lastTireModelMap = $lastTiremodelMapTrailer;
    				/*--}}
    			@endif
    			
    			@if(($key > 15 && $key < 32) || 
    					($key < 16 && strpos($modelMapTractor, '1') === false) ||
    					($key > 31 && strpos($modelMapTrailer, '1') === false)
    			)
        			{{--*/ continue; /*--}}
    			@endif
    
    			@if(($lastTireModelMap > $key || $col != 4) && !$final)
    				
    				@if($lastTireModelMap <= $key && $col == 4)
    					{{--*/ 
    						$final = true;
    						break;
    					/*--}}
    				@endif
    
        			@if($col == 4)
            		{{--*/ $col = 1; /*--}}
            		@else
            		{{--*/ $col++; /*--}}
        			@endif
        				    	
            		@if($col == 1)
        	    	<div class="mdl-grid" style="height: 100px;">
        		    	<div class="mdl-cell mdl-cell--2-col">
        		    		&nbsp;
        		    	</div>
        		    @endif
        		    
            		
    		    	<div id="pos{{$key + 1}}" class="@if($value == 1) @if(isset($fleetData['tireData'][$vehicle->id][$key + 1])) @if(empty($fleetData['tireData'][$vehicle->id][$key + 1]->color)) mdl-color--green @else mdl-color--{{$fleetData['tireData'][$vehicle->id][$key + 1]->color}} @endif @else mdl-color--grey @endif @endif tires-fleet mdl-cell mdl-cell--1-col">
					
    		    	@if($value == 1)
    		    		<div class="@if(strlen($key + 1) > 1) vehicle-map-tire-number @else vehicle-map-tire-number-simple @endif">{{$key + 1}}</div>
                        <div @if(empty($fleetData['tireData'][$vehicle->id][$key + 1]->pressure) && empty($fleetData['tireData'][$vehicle->id][$key + 1]->temperature)) style="display:none" @endif class="mdl-tooltip mdl-tooltip-blurry" id="tireData{{$key + 1}}_{{$vehicle->id}}" for="pos{{$key + 1}}">
                        @if(!empty($fleetData['tireData'][$vehicle->id][$key + 1]->pressure) || !empty($fleetData['tireData'][$vehicle->id][$key + 1]->temperature))
                        {{Lang::get("general.pressure")}}: {{$fleetData['tireData'][$vehicle->id][$key + 1]->pressure}} - {{Lang::get("general.temperature")}}: {{$fleetData['tireData'][$vehicle->id][$key + 1]->temperature}}
                        @endif
                        </div>
    		    	@endif
    		    	</div>
    		    	
					@if($value == 1 && in_array($key + 1, $tireSensorData['positions']))
					<input type="checkbox" id="graph_{{$key + 1}}" class="tireSelectCheckbox">
					@elseif($value == 1)
					<input type="checkbox" disabled id="graph_{{$key + 1}}" class="tireSelectCheckbox">
					@endif
        		    	
        		    @if($col == 2)
        	    		<div class="mdl-cell mdl-cell--3-col">
        		    		&nbsp;
        		    	</div>
        		    @endif
        		    	
        		    @if($col == 4)
            		</div>
        		    @endif
    		    @endif	
    		    
    		@endforeach    	
    	@endif
        	<div class="mdl-color-text--grey tires-back">
        		<span>]</span>
        	</div>
        	
            <div @if(empty($gpsData->latitude) && empty($gpsData->longitude)) style="display:none" @endif class="mdl-tooltip mdl-tooltip-blurry" id="gpsData{{$vehicle->id}}" for="vehicle{{$vehicle->id}}">
            @if(!empty($gpsData->latitude) || !empty($gpsData->longitude))
            {{Lang::get("general.latitude")}}: {{$gpsData->latitude}} - {{Lang::get("general.longitude")}}: {{$gpsData->longitude}}
            @endif
            </div>
            
        </div>
    </div>

	<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
    	<div class="mdl-card__actions">
          <a href="$cardLink" id="history" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            {{Lang::get("general.History")}}
          </a>
    	</div>
    	
    	<div class="mdl-card__actions mdl-card--border"></div>
    	
    	<div class="mdl-grid">
           <div class="mdl-layout-spacer"></div>
           <div class="mdl-cell mdl-cell--12-col">
           <form id="selectDates">
           	{{Lang::get("general.InitialDate")}}: <input type="text" id="datetime_ini" size="7" value="{{$dateIni}}">
           	{{Lang::get("general.InitialTime")}}: <input type="text" id="time_ini" size="7" value="{{$timeIni}}">
           	{{Lang::get("general.EndTime")}}: <input type="text" id="time_end" size="7" value="{{$timeEnd}}">
           	<input type="submit">
           </form>
           </div>
           <div class="mdl-layout-spacer"></div>
        </div>
    	
    	<div class="mdl-card__actions"></div>
    	
    	<div class="mdl-grid">
           <div class="mdl-layout-spacer"></div>
           <div class="mdl-cell mdl-cell--12-col">
    		<input type="checkbox" id="graph_temperature" checked><span style="color: #0000ff">{{Lang::get("general.temperature")}}</span><br/>
          	<input type="checkbox" id="graph_pressure" checked><span style="color: #FFA500">{{Lang::get("general.pressure")}}</span><br/>
             <input type="checkbox" id="graph_battery" disabled>{{Lang::get("general.battery")}} <span style="color: #cccccc">({{Lang::get("general.availableSoon")}})</span><br/>
             <input type="checkbox" id="graph_weight" disabled>{{Lang::get("general.weight")}} <span style="color: #cccccc">({{Lang::get("general.availableSoon")}})</span><br/>
             <input type="checkbox" id="graph_speed" disabled>{{Lang::get("general.speed")}} <span style="color: #cccccc">({{Lang::get("general.availableSoon")}})</span><br/>
             <input type="checkbox" id="graph_altitude" disabled>{{Lang::get("general.altitude")}} <span style="color: #cccccc">({{Lang::get("general.availableSoon")}})</span><br/>
             <input type="checkbox" id="graph_alarm" disabled>{{Lang::get("general.alarm")}} <span style="color: #cccccc">({{Lang::get("general.availableSoon")}})</span><br/><br/><br/>
       		 @if(empty($tireSensorData['data']))
               <span style="color: #f00">{{Lang::get("general.TireSensorDataNotFound")}}</span>
    		 @endif
    		 <span id="selectTireMessage" style="color: #f00; display:none">{{Lang::get("general.SelectTireMessage")}}</span>
           </div>
           <div class="mdl-layout-spacer"></div>
        </div>

		@if(!empty($tireSensorData['data']))
        <div id="chart_div" style="width: 1500px; height: 500px; display:none"></div>
		@endif
        
    </div>
</div>

<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

	var data = new google.visualization.DataTable();

	data.addColumn('string', 'Id');
	@foreach($tireSensorData['positions'] as $i => $position)
	data.addColumn('number', '{{$position}} - {{Lang::get("general.temperature")}}');
	data.addColumn('number', '{{$position}} - {{Lang::get("general.pressure_googlechart")}}');
	@endforeach
            		
	data.addRows([
	  @foreach($tireSensorData['data'] as $index => $data)
  	      ['{{$data["time"]}}'{{$data[$index]}}],
	  @endforeach
    ]);
    var options = {interpolateNulls: true, legend: 'bottom',

        series: {0: {targetAxisIndex:1},
            @foreach($tireSensorData['positions'] as $i => $position)
            {{2 * $i + 1}} :{targetAxisIndex:0},
            {{2 * $i + 2}} :{targetAxisIndex:1},
            @endforeach
        },
        vAxis: {
          scaleType: 'linear',
        }
    };
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

	@if(!empty($tireSensorData['data']))
    chart.draw(data, options);
    @endif
            	    
	$(" @foreach($tireSensorData['columns'] as $key => $value)#graph_{{$key}}@if(next($tireSensorData['columns'])), @endif @endforeach ").click(function() {

		if($('.tireSelectCheckbox:checked').length == 0){
  	 	  $("#selectTireMessage").show();
  	 	  $("#chart_div").hide();
  		} else {
    		$("#selectTireMessage").hide();
     	  	$("#chart_div").show();
		}
            		
		view = new google.visualization.DataView(data);
            		
		@foreach($tireSensorData['columns'] as $key => $value)    		
		if(!$("#graph_{{$key}}").is(':checked')) {
    		@foreach($tireSensorData['columns'][$key] as $column) 
          	view.hideColumns([{{$column}}]); 
    		@endforeach
		}
		@endforeach

		@if(!empty($tireSensorData['data']))
      	chart.draw(view, options);
	    @endif
	});

    if($('.tireSelectCheckbox:checked').length == 0){
 	  $("#selectTireMessage").show();
 	  $("#chart_div").hide();
	}
          	       
  }

            		
    $('a[href="#tab1"]').on('click',function(){
    	setTimeout(
    	  function() 
    	  {
    		drawChart();        
    	  }, 2);
    });

	$("#selectDates").submit(function(e){
        e.preventDefault();

		var datetime_ini = $("#datetime_ini").val();
		var datetime_end = '-';

        if(datetime_ini.indexOf("/") > 0) {
    		split = datetime_ini.split('/');
    		datetime_ini = split[2] + "-" +split[1]+"-"+split[0];
		}

		if(datetime_ini.length != 10) {
			datetime_ini = '-';
		}

    	if($("#time_ini").val().indexOf(":") != 2 && $("#time_ini").val().indexOf(":") != 3) {
    		$("#time_ini").val('{{date("H:i:s")}}');
    	}
    	if($("#time_end").val().indexOf(":") != 2 && $("#time_end").val().indexOf(":") != 3) {
    		$("#time_end").val('23:59:59');
    	}

		datetime_end = datetime_ini + " " + $("#time_end").val();
    	datetime_ini += " " + $("#time_ini").val();
            		
		window.location.href = "{{url('/')}}/vehicle/{{$vehicle->id}}/" + datetime_ini + "/" + datetime_end;
    });
            	    
	(function() {
      var x = new mdDateTimePicker({
        type: 'date',
		future: moment().add(21, 'years')
      });
      var y = new mdDateTimePicker({
        type: 'date',
		future: moment().add(21, 'years')
      });
      $('#datetime_ini')[0].addEventListener('click', function() {
		x.trigger($('#datetime_ini')[0]);
		$('#datetime_ini').parent().addClass('is-dirty');
        x.toggle();
      });
      // dispatch event test
      $('#datetime_ini')[0].addEventListener('onOk', function() {
        this.value = x.time().format('{!!Lang::get("masks.dateDatepicker")!!}').toString();
      });
    }).call(this);
		
	$( document ).ready(function() {
		$("#datetime_ini").mask('{!!Lang::get("masks.datetime")!!}');
    	$('#time_ini').mask('00:00:00');
    	$('#time_end').mask('00:00:00');
	});

    $(window).bind("load", function() {
    	var page = '{{Request::path()}}'
		if(page.length > 15) {
            // remove all is-active classes from tabs
            $('a.mdl-tabs__tab').removeClass('is-active');
            // activate desired tab
            $('a[href="#tab1"]').addClass('is-active');
            // remove all is-active classes from panels
            $('.mdl-tabs__panel').removeClass('is-active');
            // activate desired tab panel
            $('#tab1').addClass('is-active');
    		drawChart();   
    		window.location.href='#history';     
		}
	});  
	
</script>
