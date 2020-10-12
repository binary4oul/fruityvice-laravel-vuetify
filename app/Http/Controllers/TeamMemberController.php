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

        if($member_user){
            $user = auth()->user();
            $team = Team::where('owner', $user->id)->first();
            $member_data['teamid'] = $team['id'];
            $member_data['userid'] = $member_user['id'];
            $member = TeamMember::create($member_data);
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
