<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\Project;
use App\Models\Person;

class AddressController extends Controller
{
  public function create(Request $request)
  {
    $user = auth()->user();
    $address = $request->all();
    $project_id = $address['project_id'];
    unset($address['project_id']);
    $project = Project::with('person')->find($project_id);

    $address['person_id'] = $project['person']['id'];
    $address['created_by'] = $user->id;
    $address['updated_by'] = $user->id;
    //disable primary phone
    if(array_key_exists('primary', $address)){
      if($address['primary'] == true){
        Address::where('person_id', $address['person_id'])
            ->where('primary', true)
            ->update(['primary'=>false]);
      }
    }
    $res_address = Address::create($address);
    $res_address->person()->associate($project['person'])->save();
    return $res_address;
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    //disable primary Address
    $address = Address::find($id);
    if(array_key_exists('primary', $input)){
      if($input['primary'] == true){
        Address::where('person_id', $address['person_id'])
            ->where('primary', true)
            ->update(['primary'=>false]);
      }
    }
    //Update Address
    $user = auth()->user();
    $input['updated_by'] = $user->id;
    $result = Address::find($id)->update($input);
    $response= $address;
    return $response;
  }

  public function destroy($id)
  {
      $address = Address::find($id);
      $phone->delete();
      $response['status'] = "success";
      return $response;
  }

  public function getAddressType()
  {
      $addresstype = DB::table('addresstype')->get();
      $response = $addresstype;
      return $response;
  }

  public function getStates(){
      $states = DB::table('states')->get();
      return $states;
  }
}
