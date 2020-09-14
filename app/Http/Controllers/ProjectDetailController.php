<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStyle;

class ProjectDetailController extends Controller
{
    //
    public function create(Request $request)
    {
        $user = auth()->user();
        $projectdetail = $request->all();
        $projectdetailstyles = $projectdetail['projectdetailstyles'];

        unset($projectdetail['projectdetailstyles']);

        $projectdetail = ProjectDetail::create($projectdetail);
        foreach($projectdetailstyles as $projectdetailstyle){
            $projectdetailstyle['projectdetailid'] = $projectdetail['id'];
            $projectdetailstyle = ProjectDetailStyle::create($projectdetailstyle);
        }
        $projectdetail['projectdetailstyles'] = $projectdetailstyles;

        return $projectdetail;
    }

    public function update(Request $request, $id)
    {
        $projectdetail = $request->all();
        $projectdetailstyles = $projectdetail['projectdetailstyles'];
        unset($projectdetail['projectdetailstyles']);
        $res = ProjectDetail::find($id)->update($projectdetail);
        foreach($projectdetailstyles as $projectdetailstyle){
            $projectdetailstyle['projectdetailid'] = $projectdetail['id'];
            $projectdetailstyle = ProjectDetailStyle::create($projectdetailstyle);
        }
        $projectdetail['projectdetailstyles'] = $projectdetailstyles;

        return $projectdetail;
    }

    public function destroy($id)
    {
        $projectdetail = ProjectDetail::find($id)->first();
        $projectdetail->delete();
        $response['status'] = "success";
        return $response;
    }

}
