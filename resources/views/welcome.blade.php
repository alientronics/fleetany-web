@extends('layouts.default')

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
<div class="mdl-layout mdl-js-layout mdl-color--grey-100">
	<main class="mdl-layout__content">
	
		@include ('includes.statistics.cardnumber', ['statistics' => $vehiclesStatistics])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $servicesStatistics])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $tripsStatistics])
		
		@include ('includes.statistics.cardbarchart', ['statistics' => $lastsFuelCostStatistics, 
														'x_desc' => 'Mes',
														'y_desc' => 'Custo',
														'name' => 'fuel_cost',  
		])
		
	</main>
</div>

@endsection
