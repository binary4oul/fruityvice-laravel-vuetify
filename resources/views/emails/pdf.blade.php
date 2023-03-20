<div style="padding:20px 10px 10px 20px">
  <div style="text-align:center">
    <img src="{{ $contracttemplate['logo'] }}" style="width:40%; height:auto" alt="" />
  </div> 
  <p>{{ $contracttemplate['name'] }}</p>
  <p>{{ $contracttemplate['notetocustomer'] }}</p>
  <div>
    <h3>Scope of work: </h3>
    <div style="padding-left:10px">{{ $contracttemplate['scopeofwork'] }}</div>
  </div>
  <div>
    <h3>Some common conditions to be aware of:</h3>
    <div style="padding-left:10px">{{ $contracttemplate['commoncondition'] }}</div>
  </div>
  <div>{{ $contracttemplate['downpaymentterms'] }}</div>
  <div>{{ $contracttemplate['note'] }}</div>
  <div>{{ $contracttemplate['conclusion'] }}</div>
</div>

<div style="position:fixed; bottom:-60px; left: 0px; right: 0px; height: 50px;">
  {{ $contracttemplate['footer'] }}
</div>

<div style="padding:10px 10px 10px 20px">

  @foreach($project_details as $detail)
  <span style="background-color:green">Option {{ $loop->index + 1 }}</span>
  <div style="margin-left:10px">
    {{ $detail['system_name'] }}
    <br />
    <div style="margin-left:20px; background-color:yellow">
      Total
      <span style="margin-left:100px;">@ ${{ $detail['saleprice'] }}psf &nbsp;&nbsp;${{ $detail['areaprice'] }}</span>
    </div>
  </div>
  @endforeach

  <h4>Total Price : {{ $price }}</h4>
</div>