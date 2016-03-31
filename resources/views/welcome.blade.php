@extends('layouts.default')

@section('content')

<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
</script>

<div class="mdl-grid demo-content">
	
		@include ('includes.statistics.cardnumber', ['statistics' => $vehiclesStatistics])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $servicesStatistics])
		
		@include ('includes.statistics.cardnumber', ['statistics' => $tripsStatistics])
		
		@include ('includes.statistics.cardbarchart', ['statistics' => $lastsFuelCostStatistics, 
														'x_desc' => 'Mes',
														'y_desc' => 'Custo',
														'name' => 'fuel_cost',  
		])

		@include ('includes.statistics.cardbarchart', ['statistics' => $lastsServiceCostStatistics, 
														'x_desc' => 'Mes',
														'y_desc' => 'Custo',
														'name' => 'service_cost',  
		])
		
</div>

@endsection
