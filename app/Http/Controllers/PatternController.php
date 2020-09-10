<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;
class PatternController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $input = $request->all();
        $input['created_by'] = $user->id;
        $input['updated_by'] = $user->id;
        $count = Pattern::where('created_by', $user->id)->where('name', $input['name'])->count();
        if($count > 0){
            $response['status'] = "error";
            $response['message'] = "pattern name duplicated!";
        }
        else{
            $response = Pattern::create($input);
            $response['status'] = "success";
        }
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $count = Pattern::where('created_by', $user->id)->where('name', $input['name'])->count();
        if($count > 0){
            $response['status'] = "error";
            $response['message'] = "pattern name duplicated!";
        }
        else{
            $input['updated_by'] = $user->id;
            $result = Pattern::find($id)->update($input);
            $pattern = Pattern::find($id);
            $response = $pattern;
            $response['status'] = "success";
        }
        return $response;
    }
    public function list()
    {
        $user = auth()->user();
        $pattern = Pattern::where('created_by', $user->id)->get();
        $response = $pattern;
        return $response;
    }

    public function destroy($id)
    {
        $pattern = Pattern::findOrFail($id);
        $pattern->delete();
        $response['status'] = 'success';
        return $response;
    }
}
