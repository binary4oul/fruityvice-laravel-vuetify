<div>
  <h4>Estimates</h4>
  <table>
    <tr>
      <th style="padding-left:10px">Area Name</th>
      <th style="padding-left:10px">System</th>
      <th style="padding-left:10px">Area</th>
      <th style="padding-left:10px">price</th>
    </tr>
    @foreach($projectdetails as $detail)
      <tr>
      <td style="padding-left:10px">{{ $detail['name'] }}</td>
      <td style="padding-left:10px">{{ $detail['systemname'] }}</td>
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