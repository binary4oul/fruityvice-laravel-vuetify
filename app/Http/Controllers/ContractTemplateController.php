<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractTemplate;

class ContractTemplateController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        $contracttemplate = $request->all();
        $contracttemplate['created_by'] = $user->id;
        $contracttemplate['updated_by'] = $user->id;
        $response = ContractTemplate::create($contracttemplate);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $input['updated_by'] = $user->id;
        $result = ContractTemplate::find($id)->update($input);
        $contracttemplate = ContractTemplate::find($id);
        $response = $contracttemplate;
        return $response;
    }

    public function show($id){
        $contractTemplate = ContractTemplate::find($id);
        $response = $contractTemplate;
        return $response;
    }

    public function list()
    {
        $user = auth()->user();
        $contracttemplate = ContractTemplate::where('created_by', $user->id)->get();
        $response = $contracttemplate;
        return $response;
    }

    public function destroy($id)
    {
        $contracttemplate = ContractTemplate::findOrFail($id);
        $contracttemplate->delete();
        $response['status'] = 'success';
        return $response;
    }

}
