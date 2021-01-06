<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System;
use App\Models\SystemDetail;

class SystemController extends Controller
{
  public function create(Request $request)
  {
    $user = auth()->user();
    $input = $request->all();
    $res_check = $this->checkData($input);
    if($res_check['status'] != 'success') return $res_check;
    $system['name'] = $input['name'];
    $system['saleprice'] = $input['saleprice'];
    $system['created_by'] = $user->id;
    $system['updated_by'] = $user->id;
    if(array_key_exists('active', $input)) $system['active'] = $input['active'];
    if(array_key_exists('share', $input)) $system['share'] = $input['share'];
    $res_system = System::create($system);

    $system_details = $input['system_details'];
    foreach ($system_details as $system_detail) {
      $system_detail['system_id'] = $res_system['id'];
      $res_system_detail = SystemDetail::create($system_detail);
      $res_system_detail->system()->associate($res_system)->save();
    }
    $response = $res_system;
    return $response;
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    $user = auth()->user();
    $res_check = $this->checkData($input);
    if($res_check['status'] != 'success') return $res_check;
    $system['name'] = $input['name'];
    $system['saleprice'] = $input['saleprice'];
    $system['updated_by'] = $user->id;
    if(array_key_exists('active', $input)) $system['active'] = $input['active'];
    if(array_key_exists('share', $input)) $system['share'] = $input['share'];
    $result = System::find($id)->update($system);
    $res_system = System::find($id);
    $this->destroyDetail($id);
    $system_details = $input['system_details'];
    foreach ($system_details as $system_detail) {
      $system_detail['system_id'] = $res_system['id'];
      $res_system_detail = SystemDetail::create($system_detail);
      $res_system_detail->system()->associate($res_system)->save();
    }
    $response = $res_system;
    return $response;
  }

  public function show($id){
    $system = System::find($id);
    $system->systemDetails;
    $response = $system;
    return $response;
  }

  public function list()
  {
    $user = auth()->user();
    $system = System::where('created_by', $user->id)->orWhere('created_by', 'admin')->get();
    $response = $system;
    return $response;
  }

  public function destroy($id)
  {
    $system = System::findOrFail($id);
    $this->destroyDetail($system->id);
    $system->delete();
    $response['status'] = 'success';
    return $response;
  }

  public function destroyDetail($systemId)
  {
    $system = System::find($systemId);
    $system_details = $system->systemDetails;
    foreach($system_details as $system_detail) $system_detail->delete();
  }

  public function checkData($system)
  {
    $res['status'] = 'error';
    if(!array_key_exists('name', $system)) { $res['message'] = 'Input name.'; return $res; }
    if(!array_key_exists('saleprice', $system)) { $res['message'] = 'Input price.'; return $res; }
    $system_details = $system['system_details'];
    foreach($system_details as $system_detail){
      if(!array_key_exists('factor', $system_detail)) { $res['message'] = 'Ingredient Data Error!'; return $res; }
      if(!array_key_exists('price', $system_detail)) { $res['message'] = 'Ingredient Data Error!'; return $res; }
      if(!array_key_exists('extra', $system_detail)) { $system_detail['extra'] = ''; }
    }
    $res['status'] = 'success';
    return $res;
  }
}
