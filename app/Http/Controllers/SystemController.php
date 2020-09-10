<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\System;
use App\Models\SystemDetail;

class SystemController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $input = $request->all();
        $system['name'] = $input['name'];
        $system['saleprice'] = $input['saleprice'];
        $system['created_by'] = $user->id;
        $system['updated_by'] = $user->id;
        if(array_key_exists('active', $input)) $system['active'] = $input['active'];
        if(array_key_exists('share', $input)) $system['share'] = $input['share'];
        $res_system = System::create($system);

        $systemId = $res_system->id;
        $ingredients = $input['ingredients'];
        $res_ingredients = array();

        foreach ($ingredients as $ingredient) {
            $systemdetail = $ingredient;
            $systemdetail['systemid'] = $systemId;
            $systemdetail['created_by'] = $user->id;
            $systemdetail['updated_by'] = $user->id;
            $res_systemdetail = SystemDetail::create($systemdetail);
            array_push($res_ingredients, $res_systemdetail);
        }
        $res_system['ingredients'] = $res_ingredients;
        $response = $res_system;
        return $response;
    }

    public function show($id){
        $system = System::find($id);
        $system['ingredients'] = SystemDetail::where('systemid', $system->id)->get();
        $response = $system;
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $system['name'] = $input['name'];
        $system['saleprice'] = $input['saleprice'];
        $system['updated_by'] = $user->id;
        if(array_key_exists('active', $input)) $system['active'] = $input['active'];
        if(array_key_exists('share', $input)) $system['share'] = $input['share'];
        $result = System::find($id)->update($system);
        $res_system = System::find($id);

        $systemId = $res_system->id;
        $this->destroyDetail($systemId);
        $ingredients = $input['ingredients'];
        $res_ingredients = array();
        foreach ($ingredients as $ingredient) {
            $systemdetail = $ingredient;
            $systemdetail['systemid'] = $systemId;
            $systemdetail['created_by'] = $user->id;
            $systemdetail['updated_by'] = $user->id;
            $res_systemdetail = SystemDetail::create($systemdetail);
            array_push($res_ingredients, $res_systemdetail);
        }
        $res_system['ingredients'] = $res_ingredients;
        $response = $res_system;
        return $response;
    }

    public function list()
    {
        $user = auth()->user();
        $system = System::where('created_by', $user->id)->get();
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
        $systemIngredients = SystemDetail::where('systemid', $systemId)->get();
        foreach($systemIngredients as $systemIngredient) $systemIngredient->delete();
    }
}
