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
        $input = $request->all();
        $projectId = $input['projectid'];
        $this->destroy($input['projectid']);
        $projectdetails = $input['projectdetails'];
        foreach($projectdetails as $projectdetail){
            $projectdetail['projectid'] = $projectId;
            $projectdetailstyles = $projectdetail['projectdetailstyles'];

            unset($projectdetail['projectdetailstyles']);

            $projectdetail = ProjectDetail::create($projectdetail);
            foreach($projectdetailstyles as $projectdetailstyle){
                $projectdetailstyle['projectdetailid'] = $projectdetail['id'];
                $projectdetailstyle = ProjectDetailStyle::create($projectdetailstyle);
            }
            $projectdetail['projectdetailstyles'] = $projectdetailstyles;
        }
        return $projectdetails;
    }

    public function update(Reuqest $request, $id)
    {
        $this->destroy($id);
        $projectdetails = $input['projectdetails'];
        foreach($projectdetails as $projectdetail){
            $projectdetail['projectid'] = $projectId;
            $projectdetailstyles = $projectdetail['projectdetailstyles'];

            unset($projectdetail['projectdetailstyles']);

            $projectdetail = ProjectDetail::create($projectdetail);
            foreach($projectdetailstyles as $projectdetailstyle){
                $projectdetailstyle['projectdetailid'] = $projectdetail['id'];
                $projectdetailstyle = ProjectDetailStyle::create($projectdetailstyle);
            }
            $projectdetail['projectdetailstyles'] = $projectdetailstyles;
        }
        return $projectdetails;
    }

    public function destroy($projectId)
    {
        $projectdetails = ProjectDetail::where('projectid', $projectId)->get();
        foreach($projectdetails as $projectdetail)
        {
            $projectdetailstyles = ProjectDetailStyle::where('projectdetailid', $projectdetail['id'])->get();
            foreach($projectdetailstyles as $projectdetailstyle) $projectdetailstyle->delete();
            $projectdetail->delete();
        }
    }

}
