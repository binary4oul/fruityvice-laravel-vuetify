<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamMember;
use App\User;
use App\Models\Address;

class TeamMemberController extends Controller
{
    //
    public function getMembers(){
        $user = auth()->user();
        $team = Team::where('owner', $user->id)->first();
        if ($team) {
            $team['member'] = TeamMember::where('teamid', $team->id)->get();
            foreach($team['member'] as $team_member){
                $member = User::where('id', $team_member['userid'])->first();
                $team_member['name'] = $member['firstname'].' '.$member['lastname'];
                $team_member['email'] = $member['email'];
            }
            $res['member'] = $team['member'];
            $res['status'] = 'success';
        }
        else $res['status'] = 'error';
        return $res;
    }

    public function create(Request $request){
      $input = $request->all();
      $email = $input['email'];
      $member_user = User::where('email', $email)->first();
      if($input['role'] != 'member' && $input['role'] != 'manager'){
        $response['status'] = "error";
        return $response;
      }
      if($member_user){
        $user = auth()->user();
        $team = Team::where('owner', $user->id)->first();
        $member_data['teamid'] = $team['id'];
        $member_data['userid'] = $member_user['id'];
        $member_data['role'] = $input['role'];
        $member = TeamMember::create($member_data);
        $member['name'] = $member_user['firstname'].' '.$member_user['lastname'];
        $member['email'] = $member_user['email'];
        $response['status'] = "success";
        $response['member'] = $member;
      }
      else {
          $response['status'] = "error";
      }
      return $response;
    }

    public function update(Request $request, $id){
      $input = $request->all();
      $email = $input['email'];
      $member_user = User::where('email', $email)->first();
      if($input['role'] != 'member' && $input['role'] != 'manager'){
        $response['status'] = "error";
        $response['message'] = "Invalid Role!";
        return $response;
      }
      if($member_user){
        $user = auth()->user();
        $team = Team::where('owner', $user->id)->first();
        $member_data['teamid'] = $team['id'];
        $member_data['userid'] = $member_user['id'];
        $member_data['role'] = $input['role'];
        $member = TeamMember::find($id)->update($member_data);
        $member = TeamMember::find($id);
        $member['name'] = $member_user['firstname'].' '.$member_user['lastname'];
        $member['email'] = $member_user['email'];
        $response['status'] = "success";
        $response['member'] = $member;
      }
      else {
          $response['status'] = "error";
      }
      return $response;
    }



    public function delete($id){
        $member = TeamMember::find($id);
        $member->delete();
        $response['status'] = "success";
        return $response;
    }
}
