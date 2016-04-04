@section('filter')

      @permission('create.user')
      <a href="{{url('/')}}/user/create" class="button mdl-add__button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary">
        <i class="material-icons">add</i>
      </a>
      @endpermission

    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color--primary mdl-button--search">
      <i class="material-icons">filter_list</i>
    </button>
      
    <form method="get" id="search">
      <div class="demo-drawer mdl-layout__drawer-right">
        <span class="mdl-layout-title mdl-color--amber mdl-color-text--white">{{Lang::get('general.Search')}}<span class="mdl-search__div-close"><i class="material-icons">highlight_off</i></span></span>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('name', $filters['name'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('name', Lang::get('general.name'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('email', $filters['email'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('email', Lang::get('general.email'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('contact_id', $filters['contact-id'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('contact_id', Lang::get('general.contact_id'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label mdl-search__div" data-upgraded="eP">
     		{!!Form::text('company_id', $filters['company-id'], array('class' => 'mdl-textfield__input mdl-search__input'))!!}
    		{!!Form::label('company_id', Lang::get('general.company_id'), array('class' => 'mdl-textfield__label is-dirty'))!!}
         </div>
         <button type="submit" class="mdl-button mdl-color--amber mdl-color-text--white mdl-js-button mdl-button--raised mdl-button--colored mdl-search__button">
    		{{Lang::get('general.Search')}}
         </button>
      </div>
    </form>

@stop
