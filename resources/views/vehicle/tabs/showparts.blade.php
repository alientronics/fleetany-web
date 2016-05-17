@if(!empty($parts))
	<div class="mdl-grid demo-content">
        @include('includes.gridview', [
        	'registers' => $parts,
        	'gridview' => [
        		'pageActive' => 'part',
             	'sortFilters' => [
                    ["class" => "mdl-cell--4-col", "name" => "vehicle", "lang" => "general.vehicle"], 
                    ["class" => "mdl-cell--hide-phone mdl-cell--hide-tablet mdl-cell--4-col", "name" => "part-type", "lang" => "general.part_type"], 
                    ["class" => "mdl-cell--hide-phone mdl-cell--2-col", "name" => "cost", "lang" => "general.cost", "mask" => "money"],
        		] 
        	]
        ])
    </div>
@endif