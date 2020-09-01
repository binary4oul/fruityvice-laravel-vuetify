<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class PersonController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $result = Person::find($id)->update($input);
        $person = Person::find($id);
        $response = $person;
        return $response;
    }

}
