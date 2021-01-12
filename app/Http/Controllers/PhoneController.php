<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Phone;
use App\Models\Project;
use App\Models\Person;

class PhoneController extends Controller
{
    //
  public function create(Request $request)
  {
    $user = auth()->user();
    $phone = $request->all();
    $project_id = $phone['project_id'];
    unset($phone['project_id']);
    $project = Project::with('person')->find($project_id);

    $phone['person_id'] = $project['person']['id'];
    $phone['created_by'] = $user->id;
    $phone['updated_by'] = $user->id;
    //disable primary phone
    if(array_key_exists('primary', $phone)){
      if($phone['primary'] == true){
        Phone::where('person_id', $phone['person_id'])
            ->where('primary', true)
            ->update(['primary'=>false]);
      }
    }

    $res_phone = Phone::create($phone);
    $res_phone->person()->associate($project['person'])->save();
    return $res_phone;
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    //disable primary phone
    $phone = Phone::find($id);
    if(array_key_exists('primary', $input)){
        if($input['primary'] == true){
            Phone::where('person_id', $phone['person_id'])
                ->where('primary', true)
                ->update(['primary'=>false]);
        }
    }
    //Update Phone
    $user = auth()->user();
    $input['updated_by'] = $user->id;
    $result = Phone::find($id)->update($input);
    $phone = Phone::find($id);
    $response = $phone;
    return $response;
  }

  public function destroy($id)
  {
    $phone = Phone::find($id);
    $phone->delete();
    $response['status'] = "success";
    return $response;
  }

  public function getPhoneType()
  {
    $phonetype = DB::table('phonetype')->get();
    $response = $phonetype;
    return $response;
  }

}
