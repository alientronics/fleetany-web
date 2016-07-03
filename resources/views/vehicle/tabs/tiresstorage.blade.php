<table class="mdl-data-table mdl-shadow--2dp" style="width: 105%; margin-left:-20px;">
  <thead>
    <tr>
      <th></th>
      <th class="mdl-data-table__cell--non-numeric">{{Lang::get('general.number')}}</th>
      <th>{{Lang::get('general.Model')}}</th>
      <th>{{Lang::get('general.miliage')}}</th>
      <th>{{Lang::get('general.lifecycle')}}</th>
    </tr>
  </thead>
  <tbody>
  
  @foreach($tires as $key => $tire)
    @if(empty($tire->vehicle_id) || $tire->position == 0)
    <tr>
       <td>
        <input type="radio" id="row[{{$key}}]" name="tire-storage-id" value="{{$tire->id}}" />
      </td>
      <td>{{$tire->number}}</td>
      <td>{{$tire->tire_model}}</td>
      <td>{{$tire->miliage}}</td>
      <td>{{$tire->lifecycle}}</td>
    </tr>
    @endif
  @endforeach
  </tbody>
</table>