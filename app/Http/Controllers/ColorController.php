<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\IngredientColor;

class ColorController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $input = $request->all();
        $input['created_by'] = $user->id;
        $input['updated_by'] = $user->id;
        $count = Color::where('created_by', $user->id)->where('name', $input['name'])->count();
        if($count > 0){
            $response['status'] = "error";
            $response['message'] = "color name duplicated!";
        }
        else{
            $response = Color::create($input);
            $response['status'] = "success";
        }
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $count = Color::where('created_by', $user->id)->where('name', $input['name'])->count();
        if($count > 0){
            $response['status'] = "error";
            $response['message'] = "color name duplicated!";
        }
        else{
            $input['updated_by'] = $user->id;
            $result = Color::find($id)->update($input);
            $color = Color::find($id);
            $response = $color;
            $response['status'] = "success";
        }
        return $response;
    }

    public function list()
    {
      $user = auth()->user();
      $colors = Color::where('created_by', $user->id)->get();
      $response = $colors;
      return $response;
    }

    public function destroy($id)
    {
      $color = Color::findOrFail($id);
      $color->delete();
      $ingredient_colors = IngredientColor::where('colorid', $id)->get();
      foreach($ingredient_colors as $ingredient_color) $ingredient_color->delete();
      $response['status'] = 'success';
      return $response;
    }
}
