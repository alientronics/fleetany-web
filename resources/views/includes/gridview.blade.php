<div class="mdl-cell mdl-cell--12-col mdl-grid">
	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
        <div class="mdl-grid">
          <div class="mdl-cell mdl-cell--1-col"><a href="{{url('/')}}/{{$filters['sort_url']['id']}}">{{Lang::get("general.id")}}</a></div>
          
          @foreach($gridview['sortFilters'] as $sortFilter)
          <div class="mdl-cell {{$sortFilter['class']}}"><a href="{{url('/')}}/{{$filters['sort_url'][$sortFilter['name']]}}">{{Lang::get($sortFilter['lang'])}}</a></div>
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
          
          
          <div class="mdl-cell {{$gridview['sortFilters'][0]['class']}}">@if (!empty($register->vehicle->model->name)) {{$register->vehicle->model->name}} @endif</div>
          <div class="mdl-cell {{$gridview['sortFilters'][1]['class']}}">@if (!empty($register->type->name)) {{$register->type->name}} @endif</div>
          <div class="mdl-cell {{$gridview['sortFilters'][2]['class']}}">@if (!empty($register->pickup_date)) {{$register->pickup_date}} @endif</div>
          <div class="mdl-cell {{$gridview['sortFilters'][3]['class']}}">@if (!empty($register->fuel_cost)) {{$register->fuel_cost}} @endif</div>
          
          
          
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