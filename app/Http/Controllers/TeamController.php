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
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $input = $request->all();
    $input['owner'] = $user->id;
    $team = Team::create($input);
    return $team;
  }

  public function update(Request $request, $id)
  {
    $input = $request->all();
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $result = Team::find($id)->update($input);
    $response = Team::find($id);
    $response['status'] = "success";
    return $response;
  }

  public function getTeamList(){
    $user = auth()->user();
    $user_teams = TeamMember::where('user_id', $user->id)->get();
    $teams = array();
    foreach($user_teams as $user_team) {
      $team = Team::where('id', $user_team['team_id'])->first();
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

    $projects = Project::with('person')->where('created_by', $owner)->get();
    $res_projects = array();
    foreach($projects as $project){
      if($project['share'] == true) array_push($res_projects, $project);
    }

    $response = $res_projects;
    return $response;
  }

  public function getMyTeam(){
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $team = Team::with('teamMembers')->where('owner', $user->id)->first();
    if(!$team){
      $input['owner'] = $user->id;
      $input['name'] = $user->firstname.' Team';
      $team = Team::create($input);
      $team = Team::with('teamMembers')->where('owner', $user->id)->first();
    }
    $members = array();
    foreach ($team->teamMembers as $teamMember){
      $member = TeamMember::with('user')->find($teamMember['id']);
      array_push($members, $member);
    }
    $response = $team;
    $response['members'] = $members;
    return $response;
  }

  public function updateMyTeam(Request $request, $id) {
    $input = $request->all();
    $team['name'] = $input['name'];
    $team = Team::find($id)->update($team);
    return Team::find($id);
  }

  public function addNewMember(Request $request) {
    $response['status'] = 'error';
    $response['message'] = 'Team member must be an app user!';
    $user = auth()->user();
    if($user->role < 1) {
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $input = $request->all();
    $team = Team::with('teamMembers')->where('owner', $user->id)->first();
    $member = User::where('email', $input['email'])->first();
    if(!$member) return $response;
    foreach($team->teamMembers as $teamMember) {
      if($teamMember['user_id'] == $member['id']) return $response;
    }
    $teamMember_data['team_id'] = $team['id'];
    $teamMember_data['user_id'] = $member['id'];
    $teamMember_data['role'] = $input['role'];
    $res_member = TeamMember::create($teamMember_data);
    $res_member->team()->associate($team)->save();
    $res_member->user()->associate($member)->save();
    return $res_member;
  }

  public function updateMember(Request $request, $id) {
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $input = $request->all();
    $teamMember = TeamMember::with('user')->find($id);
    if($teamMember['user']['email'] != $input['email']){
      $response['status'] = 'error';
      $response['message'] = 'Cannot change User Email!';
      return $response;
    }
    $member['role'] = $input['role'];
    $teamMember = TeamMember::find($id)->update($member);
    $teamMember = TeamMember::with('user')->find($id);
    return $teamMember;
  }

  public function deleteMember($id) {
    $user = auth()->user();
    if($user->role < 1) {
      $res['status'] = 'error';
      $res['message'] = 'You need to update your Membership.';
      return $res;
    }
    $teamMember = TeamMember::find($id);
    $teamMember->delete();
    $response['status'] = 'success';
    return $response;
  }

}
