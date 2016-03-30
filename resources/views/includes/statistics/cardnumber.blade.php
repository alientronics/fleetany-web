<div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-grid">
    @foreach ($statistics as $key => $statistic)
    <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--{{12/count($statistics)}}-col mdl-cell--{{12/count($statistics)}}-col-desktop">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#piechart" mask="url(#piemask)"></use>
      <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="{{$statistic['color']}}" text-anchor="middle" dy="0.1">{{$statistic['result']}}</text>
      <text x="0.5" y="0.5" font-family="Roboto" font-size="0.1" fill="{{$statistic['color']}}" text-anchor="middle" dy="0.3">{{Lang::get("general.".$key)}}</text>
    </svg>
    @endforeach
</div>