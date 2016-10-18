<div class="mdl-grid demo-content">
    @include('includes.gridview', [
    	'registers' => $sensor_data,
    	'gridview' => [
    		'pageActive' => 'tireSensor',
         	'sortFilters' => [
                ["class" => "mdl-cell--2-col", "name" => "temperature", "lang" => "general.temperature"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--1-col", "name" => "pressure", "lang" => "general.pressure"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--1-col", "name" => "battery", "lang" => "general.battery"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "latitude", "lang" => "general.latitude"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "longitude", "lang" => "general.longitude"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--1-col", "name" => "number", "lang" => "general.part_number"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--1-col", "name" => "created-at", "mask" => 'datetime', "lang" => "general.date_and_time"]
    		] 
    	]
    ])
    
</div>

<div class="mdl-grid">
   <div class="mdl-layout-spacer"></div>
    <a href="{{URL::to('/sensor/download/'.$part->id)}}"><i class="material-icons">file_download</i></a>
   <div class="mdl-layout-spacer"></div>
</div>

