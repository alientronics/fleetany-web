<div class="mdl-grid demo-content">
    @include('includes.gridview', [
    	'registers' => $sensor_data,
    	'gridview' => [
    		'pageActive' => 'tireSensor',
         	'sortFilters' => [
                ["class" => "mdl-cell--2-col", "name" => "temperature", "lang" => "general.temperature"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "pressure", "lang" => "general.pressure"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "latitude", "lang" => "general.latitude"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "longitude", "lang" => "general.longitude"], 
                ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--2-col", "name" => "number", "lang" => "general.part_number"]
    		] 
    	]
    ])
</div>
