<div style="padding:20px 10px 10px 20px">
  <div style="text-align:center">
    <img src="{{ $contracttemplate['logo'] }}" style="width:40%; height:auto" alt="" />
  </div>
  <p>{{ $contracttemplate['name'] }}</p>
  <p>{{ $contracttemplate['notetocustomer'] }}</p>
  <div>
    <h3>Scope of work: </h3>
    <p style="padding-left:10px">{{ $contracttemplate['scopeofwork'] }}</p>
  </div>
  <div>
    <h3>Some common conditions to be aware of:</h3>
    <p style="padding-left:10px">{{ $contracttemplate['commoncondition'] }}</p>
  </div>
  <p>{{ $contracttemplate['downpaymentterms'] }}</p>
  <p>{{ $contracttemplate['note'] }}</p>
  <p>{{ $contracttemplate['conclusion'] }}</p>
</div>

<div style="padding:10px 10px 10px 20px">
  <h4>Estimates</h4>
  <table>
    <tr>
      <th style="padding-left:10px">Area Name</th>
      <th style="padding-left:10px">Area</th>
      <th style="padding-left:10px">price</th>
    </tr>
    @foreach($project_details as $detail)
      <tr>
      <td style="padding-left:10px">{{ $detail['name'] }}</td>
      <td style="padding-left:10px">{{ $detail['area'] }}</td>
      <td style="padding-left:10px">{{ $detail['areaprice'] }}</td>
      </tr>
    @endforeach
  </table>

  <h4>Total Price : {{ $price }}</h4>

  <h4>Notes</h4>
  @foreach($notes as $note)
    <p style="margin-left: 5px">{{ $note['note'] }}</p>
  @endforeach

  <h4>Images</h4>
  <div style="padding-top:30px">
  @foreach($images as $image)
    <img src="{{ $image['image'] }}" style="width:30%"/>
  @endforeach
  </div>
</div>