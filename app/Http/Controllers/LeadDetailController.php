<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadDetail;

class LeadDetailController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        $lead = $request->all();
        $lead['created_by'] = $user->id;
        $lead['updated_by'] = $user->id;
        $response = LeadDetail::create($lead);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();
        $input['updated_by'] = $user->id;
        //Update Person
        $leaddetail = LeadDetail::find($id)->update($input);
        $response = LeadDetail::find($id);
        return $response;
    }

}
