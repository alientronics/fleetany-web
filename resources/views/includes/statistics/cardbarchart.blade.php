<script type="text/javascript">
  google.charts.setOnLoadCallback(drawChart_{{$name}});
  function drawChart_{{$name}}() {
    var data = google.visualization.arrayToDataTable([
      ['{{Lang::get("general.Month")}}', '{{Lang::get("general.Cost")}}'],
      @foreach ($statistics as $key => $statistic)
      ['{{Lang::get("dates.monthShort".$key)}}', {{$statistic}}],
      @endforeach
    ]);

    var chart = new google.charts.Bar(document.getElementById('columnchart_material_{{$name}}'));
    var options = { 
      legend: {position: 'none'},
      titlePosition: 'none', axisTitlesPosition: 'none',
      hAxis: {textPosition: 'none'}, vAxis: {textPosition: 'none'}
    };    

    chart.draw(data, options);
  }
</script>

<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
    <div id="columnchart_material_{{$name}}" style="width: 900px; height: 500px;"></div>
</div>
