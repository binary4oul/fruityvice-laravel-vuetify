<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Project;
use App\Models\Address;
use App\User;
use App\Http\Controllers\ProjectController;

class TeamController extends Controller
{
  public function create(Request $request)
  {
    $user = auth()->user();
    $input = $request->all();
    $input['owner'] = $user->id;
    $team = Team::create($input);

    $member_data['teamid'] = $team['id'];
    $member_data['userid'] = $user['id'];
    $member_data['role'] = 'manager';
    $member = TeamMember::create($member_data);

    return $team;
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    $user = auth()->user();
    $result = Team::find($id)->update($input);
    $response = Team::find($id);
    $response['status'] = "success";
    return $response;
  }

  public function getTeamList(){
    $user = auth()->user();
    $user_teams = TeamMember::where('userid', $user->id)->get();
    $teams = array();
    foreach($user_teams as $user_team) {
      $team = Team::where('id', $user_team['teamid'])->first();
      $owner = User::where('id', $team->owner)->first();
      if($team->owner == $user->id) continue;
      $team['owner'] = $owner;
      $team['role'] = $user_team['role'];
      array_push($teams, $team);
    }
    return $teams;
  }

  public function getTeamProjects(Request $request, $teamid){
    $team = Team::findOrFail($teamid);
    $owner = $team['owner'];

    $projects = Project::where('created_by', $owner)->get();
    $res_projects = array();
    foreach($projects as $project){
      $lead = $this->LeadController->show($project['leadid']);
      $project['person'] = $lead['person'];
      $address = Address::find($project['addressid']);
      $project['address'] = $address;
      if($project['share'] == true) array_push($res_projects, $project);
    }

    $response = $res_projects;
    return $response;
  }

  public function getTeam(){
    $user = auth()->user();
    $team = Team::where('owner', $user->id)->first();
    if($team){
        $response['status'] = 'success';
        $response['team'] = $team;
    }
    else $response['status'] = 'error';
    return $response;
  }

}
