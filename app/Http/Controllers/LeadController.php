<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Person;
use App\Models\Address;
use App\Models\Phone;
use App\Models\LeadDetail;

class LeadController extends Controller
{
    //
  public function create(Request $request)
  {
    $user = auth()->user();
    $input = $request->all();
    $input['created_by'] = $user->id;
    $input['updated_by'] = $user->id;
    $person = Person::create($input);

    $new_lead['personid'] = $person['id'];
    $new_lead['created_by'] = $user->id;
    $new_lead['updated_by'] = $user->id;
    $lead = Lead::create($new_lead);

    $response = $person;
    $response['leadid'] = $lead['id'];

    return $response;
  }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $result = Lead::find($id)->update($input);
        $lead = Lead::find($id);
        $response = $lead;
        return $response;
    }

    public function show($id)
    {
        $lead = Lead::find($id);
        $person = Person::find($lead['personid']);
        $address = Address::where('personid', $person->id)->get();
        $phone = Phone::where('personid', $person->id)->get();
        $leaddetail = LeadDetail::where('leadid', $lead->id)->first();

        $response['lead'] = $lead;
        $response['person'] = $person;
        $response['leaddetail'] = $leaddetail;
        $response['address'] = $address;
        $response['phone'] = $phone;
        return $response;
    }

    public function list(Request $request)
    {
        $user = auth()->user();
        $leads = Lead::where('created_by', $user->id)->get();
        foreach ($leads as $lead) {
            $person = Person::where('id', $lead->personid)->first();
            $lead['person'] = $person;
        }
        $response = $leads;
        return $response;
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        $person = Person::find($lead['personid']);
        $person->delete();
        $addresses = Address::where('personid', $person->id)->get();
        foreach($addresses as $address) $address->delete();
        $phones = Phone::where('personid', $person->id)->get();
        foreach($phones as $phone) $phone->delete();
        $leaddetails = LeadDetail::where('leadid', $lead->id)->get();
        foreach($leaddetails as $leaddetail) $leaddetail->delete();
        $response['status'] = 'success';
        return $response;
    }
}
