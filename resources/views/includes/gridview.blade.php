<div class="mdl-cell mdl-cell--12-col mdl-grid">
	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--1-col"><a class="mdl-color-text--primary-contrast" href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}}</a></div>
          
          @foreach($gridview['sortFilters'] as $sortFilter)
          <div class="mdl-cell {{$sortFilter['class']}}"><a class="mdl-color-text--primary-contrast" href="{{url('/')}}/{{$filters['sort_url'][$sortFilter['name']]}}">{{Lang::get($sortFilter['lang'])}}</a></div>
          @endforeach
          @permission('delete.'.$gridview['pageActive'].'|update.'.$gridview['pageActive'])
          <div class="mdl-cell mdl-cell--1-col"></div>
          @endpermission
        </div>
    </div>
    
    
    @foreach($registers as $i => $register)
    <div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--1-col mdl-data-table__cell--non-numeric">@if (!empty($register->id)) {{$register->id}} @endif</div>
          
          @foreach($gridview['sortFilters'] as $sortFilter)
          @if(!empty($sortFilter['mask']) && $sortFilter['mask'] == 'money')
          <div class="mdl-cell {{$sortFilter['class']}}">{!! App\Repositories\HelperRepository::money($register->{$sortFilter['name']}, App::getLocale()) !!}</div>
          @elseif(!empty($sortFilter['mask']) && $sortFilter['mask'] == 'datetime')
          <div class="mdl-cell {{$sortFilter['class']}}">{!! App\Repositories\HelperRepository::date($register->{$sortFilter['name']}, App::getLocale()) !!}</div>
          @else
          <div class="mdl-cell {{$sortFilter['class']}}">{{ $register->{$sortFilter['name']} }}</div>
          @endif
          @endforeach
            
          @if(Request::is('reports*'))
          <div class="mdl-cell mdl-cell--1-col">
                @if(Request::is('reports/alerts/vehicles*'))
                	{!!Form::buttonLink( url('/reports/alerts/vehicle/'.$register->id), 'primary' , 'search' , 'Visualizar' )!!}
                @elseif(Request::is('reports/alerts/tires*'))
                	{!!Form::buttonLink( url('/reports/alerts/tire/'.$register->id), 'primary' , 'search' , 'Visualizar' )!!}
                @elseif(Request::is('reports/history/vehicles*'))
                	{!!Form::buttonLink( route('vehicle.show', $register->id) , 'primary' , 'search' , 'Visualizar' )!!}
                @elseif($gridview['pageActive'] == 'vehicle-alerts-types-report')
                	{!!Form::buttonLink( url('/reports/alerts/vehicle/'.$entity_id.'/type/'.$register->id) , 'primary' , 'search' , 'Visualizar' )!!}
                @elseif($gridview['pageActive'] == 'tire-alerts-types-report')
                	{!!Form::buttonLink( url('/reports/alerts/tire/'.$entity_id.'/type/'.$register->id) , 'primary' , 'search' , 'Visualizar' )!!}
                @endif
          </div> 
          @else              
          @permission('delete.'.$gridview['pageActive'].'|update.'.$gridview['pageActive'])
          <div class="mdl-cell mdl-cell--1-col">
                @if($gridview['pageActive'] == 'vehicle')
                	{!!Form::buttonLink( route($gridview['pageActive'].'.show', $register->id) , 'primary' , 'search' , 'Visualizar' )!!}
                @endif
                @permission('update.'.$gridview['pageActive'])
                	{!!Form::buttonLink( route($gridview['pageActive'].'.edit', $register->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                @endpermission
            	@permission('delete.'.$gridview['pageActive'])
                    {!!Form::buttonLink( url($gridview['pageActive'].'/destroy',$register->id) , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                	@include('includes.confirmoperation', ['url' => url($gridview['pageActive'].'/destroy',$register->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                @endpermission
          </div>
          @endpermission
          @endif
        </div>
    </div>
    @endforeach
    
    @if(isset($filters['pagination']))
	@include('includes.pagination', ['paginator' => $registers->appends($filters['pagination'])]) 
	@endif
	
</div>
