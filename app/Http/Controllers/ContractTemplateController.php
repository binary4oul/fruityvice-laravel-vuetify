<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractTemplate;
use Illuminate\Support\Facades\Storage;

class ContractTemplateController extends Controller
{
  public function create(Request $request)
  {
    $user = auth()->user();
    $contracttemplate = $request->all();
    if ($request->hasFile('logo')) {
      //  Let's do everything here
      if ($request->file('logo')->isValid()) {
        $validated = $request->validate([
            'image' => 'mimes:jpeg,png|max:1014',
        ]);
        $imageName = time().'.'.$request->logo->getClientOriginalExtension();

        $request->logo->storeAs('/public/images', $imageName);
        $url = url('storage/images/'.$imageName);
        $contracttemplate['logo'] = $url;
      }
    }
    $contracttemplate['created_by'] = $user->id;
    $contracttemplate['updated_by'] = $user->id;
    $response = ContractTemplate::create($contracttemplate);
    return $response;
  }

  public function set_update(Request $request, $id){
    return $request->name;

  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    $user = auth()->user();
    if ($request->hasFile('logo')) {
      //  Let's do everything here
      if ($request->file('logo')->isValid()) {
        $validated = $request->validate([
            'image' => 'mimes:jpeg,png|max:1014',
        ]);
        $imageName = time().'.'.$request->logo->getClientOriginalExtension();

        $request->logo->storeAs('/public/images', $imageName);
        $url = url('storage/images/'.$imageName);
        $input['logo'] = $url;
      }
    }

    $input['updated_by'] = $user->id;

    $result = ContractTemplate::find($id)->update($input);
    $response = ContractTemplate::find($id);
    return $response;
  }
  public function show($id)
  {
    $user = auth()->user();
    $contracttemplate = ContractTemplate::find($id);
    $response = $contracttemplate;
    if($contracttemplate) $response['status'] = 'success';
    else $response['status'] = 'error';
    return $response;
  }

  public function destroy($id)
  {
      $contracttemplate = ContractTemplate::findOrFail($id);
      $contracttemplate->delete();
      $response['status'] = 'success';
      return $response;
  }

  public function list()
  {
    $user = auth()->user();
    $contracttemplates = ContractTemplate::where('created_by', $user->id)->get();
    return $contracttemplates;

  }

}
