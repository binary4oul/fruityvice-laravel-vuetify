<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStyle;
use App\Account;

class ProjectDetailController extends Controller
{
    //
  public function create(Request $request)
  {
    $user = auth()->user();
    $project_detail = $request->all();
    $project_detail_styles = $project_detail['project_detail_styles'];
    unset($project_detail['project_detail_styles']);
    $project = Project::find($project_detail['project_id']);

    if(Account::checkTeamManager($project['id']) == true || $project['created_by'] == $user->id){
      $res_project_detail = ProjectDetail::create($project_detail);
      $res_project_detail->project()->associate($project)->save();
      foreach($project_detail_styles as $project_detail_style){
        $project_detail_style['project_detail_id'] = $res_project_detail['id'];
        $res_project_detail_style = ProjectDetailStyle::create($project_detail_style);
        $res_project_detail_style->projectDetail()->associate($res_project_detail)->save();
      }
      return $res_project_detail;
    }
    $response['status'] = 'error';
    $response['message'] = "You can't update Project";
    return $response;
  }

  public function update(Request $request, $id)
  {
    $user = auth()->user();
    $project_detail = $request->all();
    $project_detail_styles = $project_detail['project_detail_styles'];
    unset($project_detail['project_detail_styles']);
    $project = Project::find($project_detail['project_id']);

    if(Account::checkTeamManager($project['id']) == true || $project['created_by'] == $user->id){
      $res_project_detail = ProjectDetail::find($id)->update($project_detail);
      $res_project_detail = ProjectDetail::find($id);
      $res_project_detail->project()->associate($project)->save();
      if(count($project_detail_styles) > 0){
        $old_styles = ProjectDetailStyle::where('project_detail_id', $id)->get();
        foreach($old_styles as $old_style) $old_style->delete();
        foreach($project_detail_styles as $project_detail_style){
          $project_detail_style['project_detail_id'] = $res_project_detail['id'];
          $res_project_detail_style = ProjectDetailStyle::create($project_detail_style);
          $res_project_detail_style->projectDetail()->associate($res_project_detail)->save();
        }
      }
      return $res_project_detail;
    }
    $response['status'] = 'error';
    $response['message'] = "You can't update Project";
    return $response;
  }

  public function show($id)
  {
    $res_project_detail_styles = ProjectDetail::with('projectDetailStyles')->find($id);
    return $res_project_detail_styles;
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
