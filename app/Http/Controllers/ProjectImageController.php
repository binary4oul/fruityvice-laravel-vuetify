<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectImage;

class ProjectImageController extends Controller
{
    //
    public function create(Request $request)
    {
        $projectImage = $request->all();
        $response = ProjectImage::create($projectImage);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $result = ProjectImage::find($id)->update($input);
        $projectImage = ProjectImage::find($id);
        return $projectImage;
    }

    public function destroy($id)
    {
        $projectImage = ProjectImage::find($id);
        $projectImage->delete();
        $response['status'] = "success";
        return $response;
    }

    public function list($projectid){
        $projectImages = ProjectImage::where('projectid', $projectid)->get();
        return $projectImages;
    }
}
