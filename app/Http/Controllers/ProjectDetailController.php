<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStyle;
use App\Account;

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
      if(Account::checkOwner($projectdetail['projectid'])==false && Account::checkTeamManager($id)==false) return;

			$projectdetailstyles = ProjectDetailStyle::where('projectdetailid', $id)->get();
			foreach($projectdetailstyles as $projectdetailstyle) $projectdetailstyle->delete();


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
      if(Account::checkOwner($id)==false && Account::checkTeamManager($id)==false) return;

        $projectdetailstyles = ProjectDetailStyle::where('projectdetailid', $id)->get();
        foreach($projectdetailstyles as $projectdetailstyle) $projectdetailstyle->delete();
        $projectdetail = ProjectDetail::find($id)->first();
        $projectdetail->delete();
        $response['status'] = "success";
        return $response;
    }

}
