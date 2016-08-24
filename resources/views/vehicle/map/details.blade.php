	@if(!empty($data))
		@foreach($data as $key => $value)
			{{Lang::get("general.".$key)}}: {{$value}} <br/>
		@endforeach    	
		 <br/>
	@endif
