<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class MembershipController extends Controller
{
    //
    public function updateMembership(Request $request){
      $input = $request->all();
      $user = auth()->user();
      $data['role'] = $input['role'];
      $res_user = User::find($user->id)->update($data);
      $res_user = User::find($user->id);
      return $res_user;
    }
}
