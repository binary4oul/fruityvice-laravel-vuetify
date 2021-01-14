<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\IngredientColor;
use App\Models\IngredientPattern;
use App\Models\SystemDetail;

class IngredientController extends Controller
{
    //
  public function create(Request $request)
  {
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $ingredient['name'] = $request['name'];
    $ingredient['coverage'] = $request['coverage'];
    $ingredient['purchaseprice'] = $request['purchaseprice'];
    $ingredient['created_by'] = $user->id;
    $ingredient['updated_by'] = $user->id;
    if($user->role > 4){
      $ingredient['created_by'] = 'admin';
      $ingredient['updated_by'] = 'admin';
    }
    $res_ingredient = Ingredient::create($ingredient);
    $res_ingredient->colors()->sync($request['colors']);
    $res_ingredient->patterns()->sync($request['patterns']);
    $response = Ingredient::with('colors')->with('patterns')->find($res_ingredient->id);
    return $response;
  }

  public function update(Request $request, $id)
  {
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $input = $request->all();
    $input['updated_by'] = $user->id;
    $ingredient['name'] = $request['name'];
    $ingredient['coverage'] = $request['coverage'];
    $ingredient['purchaseprice'] = $request['purchaseprice'];
    $result = Ingredient::find($id)->update($ingredient);
    $ingredient = Ingredient::find($id);
    $ingredient->colors()->sync($request['colors']);
    $ingredient->patterns()->sync($request['patterns']);
    $response = Ingredient::with('colors')->with('patterns')->find($id);
    return $response;
  }

  public function list()
  {
    $user = auth()->user();
    $ingredients = Ingredient::where('created_by', $user->id)->with('colors')->with('patterns')->get();
    if($user->role > 4) $ingredients = Ingredient::where('created_by', 'admin')->with('colors')->with('patterns')->get();
    $response = $ingredients;
    return $response;
  }

  public function destroy($id)
  {
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $ingredient = Ingredient::findOrFail($id);
    $ingredient->delete();
    $system_details = SystemDetail::where('ingredient_id', $id)->get();
    foreach($system_details as $system_detail) $system_detail->delete();
    $response['status'] = 'success';
    return $response;
  }

  public function show($id)
  {
    $ingredient = Ingredient::with('colors')->with('patterns')->find($id);
    $response = $ingredient;
    return $response;
  }
}
