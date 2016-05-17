@if(count($tabs) > 1)
<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
  <div class="mdl-tabs__tab-bar">
	@foreach($tabs as $i => $tab)  
		<a href="#tab{{$i}}" class="mdl-tabs__tab @if($i == 0) is-active @endif">
			{!!Lang::get($tab['title'])!!}
		</a>
    @endforeach
  </div>
  @foreach($tabs as $i => $tab)
  <div class="mdl-tabs__panel @if($i == 0) is-active @endif" id="tab{{$i}}">
    @include($tab['view'])
  </div>
  @endforeach
</div>
@elseif(count($tabs) == 1)
  @include($tabs[0]['view'])
@endif
