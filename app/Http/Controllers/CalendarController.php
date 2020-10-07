<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;

class CalendarController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $input = $request->all();
        $input['created_by'] = $user->id;
        $input['updated_by'] = $user->id;
        $response = Calendar::create($input);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = auth()->user();

        $input['updated_by'] = $user->id;
        $result = Calendar::find($id)->update($input);
        $calendar = Calendar::find($id);
        $response = $calendar;
        return $response;
    }

    public function list()
    {
        $user = auth()->user();
        $calendars = Calendar::where('created_by', $user->id)->get();
        $response = $calendars;
        return $response;
    }

    public function destroy($id)
    {
        $calendar = Calendar::findOrFail($id);
        $calendar->delete();
        $response['status'] = 'success';
        return $response;
    }

}
