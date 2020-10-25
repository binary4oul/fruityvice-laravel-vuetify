<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    //
    public function create(Request $request)
    {
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                $validated = $request->validate([
                    'image' => 'mimes:jpeg,png|max:1014',
                ]);
                $imageName = time().'.'.$request->image->getClientOriginalExtension();

                $request->image->storeAs('/public/images', $imageName);
                $url = url('storage/images/'.$imageName);
                $projectImage['projectid'] = $request->projectid;
                $projectImage['image'] = $url;
                $response = ProjectImage::create($projectImage);
                return $response;
            }
        }
        $response = $request;
        return $response;

    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
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
