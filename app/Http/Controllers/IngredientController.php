<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\IngredientColor;
use App\Models\IngredientPattern;

class IngredientController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $ingredient['name'] = $request['name'];
        $ingredient['coverage'] = $request['coverage'];
        $ingredient['purchageprice'] = $request['purchageprice'];
        $ingredient['created_by'] = $user->id;
        $ingredient['updated_by'] = $user->id;
        $res_ingredient = Ingredient::create($ingredient);

        $req_detail['ingredientId'] = $res_ingredient->id;
        $req_detail['color'] = $request['color'];
        $req_detail['pattern'] = $request['pattern'];
        $req_detail['userid'] = $user->id;
        $res_detail = $this->createDetail($req_detail);
        $res_ingredient['color'] = $res_detail['color'];
        $res_ingredient['pattern'] = $res_detail['pattern'];
        $response = $res_ingredient;
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $input['updated_by'] = $user->id;
        $ingredient['name'] = $request['name'];
        $ingredient['coverage'] = $request['coverage'];
        $ingredient['purchageprice'] = $request['purchageprice'];
        $result = Ingredient::find($id)->update($ingredient);
        $ingredient = Ingredient::find($id);

        $this->destroyDetail($id);
        $req_detail['ingredientId'] = $ingredient->id;
        $req_detail['color'] = $request['color'];
        $req_detail['pattern'] = $request['pattern'];
        $req_detail['userid'] = $user->id;
        $res_detail = $this->createDetail($req_detail);
        $ingredient['color'] = $res_detail['color'];
        $ingredient['pattern'] = $res_detail['pattern'];
        $response = $ingredient;
        return $response;
    }

    public function list()
    {
        $user = auth()->user();
        $ingredients = Ingredient::where('created_by', $user->id)->get();
        foreach($ingredients as $ingredient){
            $ingredient['color'] = IngredientColor::where('ingredientid', $ingredient->id)->get();
            $ingredient['pattern'] = IngredientPattern::where('ingredientid', $ingredient->id)->get();
        }
        $response = $ingredients;
        return $response;
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $this->destroyDetail($id);
        $ingredient->delete();
        $response['status'] = 'success';
        return $response;
    }

    public function show($id)
    {
        $ingredient = Ingredient::find($id);
        $ingredient['color'] = IngredientColor::where('ingredientid', $ingredient->id)->get();
        $ingredient['pattern'] = IngredientPattern::where('ingredientid', $ingredient->id)->get();
        $response = $ingredient;
        return $response;
    }

    public function createDetail($request){
        $ingredientId = $request['ingredientId'];
        $colorIds = $request['color'];
        $ingredientColors = array();
        foreach ($colorIds as $colorId) {
            $ingredientColor['ingredientid'] = $ingredientId;
            $ingredientColor['colorid'] = $colorId;
            $ingredientColor['created_by'] = $request['userid'];
            $ingredientColor['updated_by'] = $request['userid'];
            $res_ingredientColor = IngredientColor::create($ingredientColor);
            array_push($ingredientColors, $res_ingredientColor);
        }
        $patternIds = $request['pattern'];
        $ingredientPatterns = array();
        foreach ($patternIds as $patternId) {
            $ingredientPattern['ingredientid'] = $ingredientId;
            $ingredientPattern['patternid'] = $patternId;
            $ingredientPattern['created_by'] = $request['userid'];
            $ingredientPattern['updated_by'] = $request['userid'];
            $res_ingredientPattern = IngredientPattern::create($ingredientPattern);
            array_push($ingredientPatterns, $res_ingredientPattern);
        }
        $response['color'] = $ingredientColors;
        $response['pattern'] = $ingredientPatterns;
        return $response;
    }

    public function destroyDetail($ingredientId){
        $ingredientColors = IngredientColor::where('ingredientid', $ingredientId)->get();
        foreach($ingredientColors as $ingredientColor) $ingredientColor->delete();
        $ingredientPatterns = IngredientPattern::where('ingredientid', $ingredientId)->get();
        foreach($ingredientPatterns as $ingredientPattern) $ingredientPattern->delete();
    }
}
