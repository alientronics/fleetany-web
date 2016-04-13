@section('filter')

    @include('includes.filter-buttons', [ 'pageActive' => 'user' ])
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--primary mdl-color-text--accent-contrast">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('name', $filters['name'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('name', Lang::get('general.name'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('email', $filters['email'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('email', Lang::get('general.email'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('contact_id', $filters['contact-id'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('contact_id', Lang::get('general.contact_id'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('company_id', $filters['company-id'], ['class' => 'mdl-textfield__input mdl-search__input'])!!}
    		{!!Form::label('company_id', Lang::get('general.company_id'), ['class' => 'mdl-textfield__label is-dirty'])!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

@stop
