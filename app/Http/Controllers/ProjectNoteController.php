<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectNote;

class ProjectNoteController extends Controller
{
    //
    public function create(Request $request)
    {
        $projectNote = $request->all();
        $response = ProjectNote::create($projectNote);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $result = ProjectNote::find($id)->update($input);
        $projectNote = ProjectNote::find($id);
        return $projectNote;
    }

    public function destroy($id)
    {
        $projectNote = ProjectNote::find($id);
        $projectNote->delete();
        $response['status'] = "success";
        return $response;
    }

    public function list($projectid){
        $projectNotes = ProjectNote::where('projectid', $projectid)->get();
        return $projectNotes;
    }
}
