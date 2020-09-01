<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();
        $address = $request->all();
        $address['created_by'] = $user->id;
        $address['updated_by'] = $user->id;

         //disable primary phone
         if(array_key_exists('primary', $address)){
            if($address['primary'] == true){
                Address::where('personid', $address['personid'])
                    ->where('primary', true)
                    ->update(['primary'=>false]);
            }
        }

        $response = Address::create($address);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        //disable primary Address
        if(array_key_exists('primary', $input)){
            if($input['primary'] == true){
                Address::where('personid', $input['personid'])
                    ->where('primary', true)
                    ->update(['primary'=>false]);
            }
        }
        //Update Address
        $user = auth()->user();
        $input['updated_by'] = $user->id;
        $result = Address::find($id)->update($input);
        $address = Address::find($id);
        $response= $address;
        return $response;
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        $phone->delete();
        $response['status'] = "success";
        return $response;
    }

    public function getAddressType()
    {
        $addresstype = DB::table('addresstype')->get();
        $response = $addresstype;
        return $response;
    }
}
