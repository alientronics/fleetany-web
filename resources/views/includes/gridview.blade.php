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
          <div class="mdl-cell {{$sortFilter['class']}}">{!! App\Repositories\HelperRepository::money($register->$sortFilter['name'], App::getLocale()) !!}</div>
          @elseif(!empty($sortFilter['mask']) && $sortFilter['mask'] == 'datetime')
          <div class="mdl-cell {{$sortFilter['class']}}">{!! App\Repositories\HelperRepository::date($register->$sortFilter['name'], App::getLocale()) !!}</div>
          @else
          <div class="mdl-cell {{$sortFilter['class']}}">{{ $register->{$sortFilter['name']} }}</div>
          @endif
          @endforeach
          
          @permission('delete.'.$gridview['pageActive'].'|update.'.$gridview['pageActive'])
          <div class="mdl-cell mdl-cell--1-col">
          		@permission('update.'.$gridview['pageActive'])
                	{!!Form::buttonLink( route($gridview['pageActive'].'.edit', $register->id) , 'primary' , 'mode_edit' , 'Editar' )!!}
                @endpermission
            	@permission('delete.'.$gridview['pageActive'])
                    {!!Form::buttonLink( url($gridview['pageActive'].'/destroy',$register->id) , 'danger show-confirm-operation' , 'delete' , 'Excluir' )!!}
                	@include('includes.confirmoperation', ['url' => url($gridview['pageActive'].'/destroy',$register->id), 'confirm' => Lang::get("general.areyousuredelete")]) 
                @endpermission
          </div>
          @endpermission
        </div>
    </div>
    @endforeach
    
	@include('includes.pagination', ['paginator' => $registers->appends($filters['pagination'])]) 
	
</div>
