@extends('layouts.default')

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Mes', 'Custo'],
      ['Out', 1000],
      ['Nov', 1170],
      ['Dez', 660],
      ['Jan', 1030],
      ['Fev', 1030],
      ['Mar', 1030]
    ]);

    var options = {
      chart: {
        title: 'Custo de Combustivel',
        subtitle: 'Custo de Combustivel',
      }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, options);
  }
</script>

	
<div class="mdl-layout mdl-js-layout mdl-color--grey-100">
	<main class="mdl-layout__content">
		<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--4-col-desktop">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#3871cf" text-anchor="middle" dy="0.1">82</text>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="#3871cf" text-anchor="middle" dy="0.3">Em uso</text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--4-col-desktop">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#38cf71" text-anchor="middle" dy="0.1">82</text>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="#38cf71" text-anchor="middle" dy="0.3">Dispon&iacute;veis</text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--4-col-desktop">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#cf3871" text-anchor="middle" dy="0.1">82</text>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="#cf3871" text-anchor="middle" dy="0.3">Em manuten&ccedil;&atilde;o</text>
            </svg>
		</div>
		<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--6-col-desktop">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#3871cf" text-anchor="middle" dy="0.1">82</text>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="#3871cf" text-anchor="middle" dy="0.3">Em uso</text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--6-col-desktop">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#38cf71" text-anchor="middle" dy="0.1">82</text>
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="#38cf71" text-anchor="middle" dy="0.3">Dispon&iacute;veis</text>
            </svg>
		</div>
		<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
            <div id="columnchart_material" style="width: 900px; height: 500px;"></div>
		</div>
	</main>
</div>

@endsection
