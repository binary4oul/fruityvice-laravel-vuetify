<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Person;
use App\Models\Phone;
use App\Models\Address;
use App\Models\ProjectDetail;
use App\Models\ProjectDetailStyle;
use App\Models\System;
use App\Account;

class ProjectController extends Controller
{
    public function create(Request $request)
    {
      $user = auth()->user();
      $input = $request->all();
      if(!array_key_exists('person', $input)) {
        $response['status'] = 'error';
        $response['message'] = 'Input Person Information';
        return $response;
      }

      $project_data['email'] = $input['email'];
      $project_data['besttimetocall'] = $input['besttimetocall'];
      $project_data['hearaboutus'] = $input['hearaboutus'];
      $project_data['howcanwehelp'] = $input['howcanwehelp'];
      $project_data['created_by'] = $user->id;
      $project_data['updated_by'] = $user->id;
      $res_project = Project::create($project_data);

      $person_data = $input['person'];
      $person_data['project_id'] = $res_project['id'];
      $res_person = Person::create($person_data);
      $res_person->project()->associate($res_project)->save();

      if(array_key_exists('number', $input['phone'])) {
        $phone_data = $input['phone'];
        $phone_data['person_id'] = $res_person['id'];
        $phone_data['primary'] = true;
        $res_phone = Phone::create($phone_data);
        $res_phone->person()->associate($res_person)->save();
      }
      if(array_key_exists('address1', $input['address'])) {
        $address_data = $input['address'];
        $address_data['person_id'] = $res_person['id'];
        $address_data['primary'] = true;
        $res_address = Address::create($address_data);
        $res_address->person()->associate($res_person)->save();
      }
      if(array_key_exists('project_detail', $input)) {
        $project_detail = $input['project_detail'];
        $project_detail_styles = $project_detail['project_detail_styles'];
        unset($project_detail['project_detail_styles']);
        $project_detail['project_id'] = $res_project['id'];
        $res_project_detail = ProjectDetail::create($project_detail);
        $res_project_detail->project()->associate($res_project)->save();
        foreach($project_detail_styles as $project_detail_style){
          $project_detail_style['project_detail_id'] = $res_project_detail['id'];
          $res_project_detail_style = ProjectDetailStyle::create($project_detail_style);
          $res_project_detail_style->projectDetail()->associate($res_project_detail)->save();
        }
      }
      $response = $res_project;
      return $response;
    }

    public function update(Request $request, $id)
    {
      $user = auth()->user();
      $project = Project::find($id);
      $input = $request->all();
      if(Account::checkTeamMember($id) == false && $project['created_by'] != $user->id) return $project;

      if(array_key_exists('install', $input)) $project_data['install'] = $input['install'];
      if(array_key_exists('designconsult', $input)) $project_data['designconsult'] = $input['designconsult'];
      if(array_key_exists('projectstatus', $input)) $project_data['projectstatus'] = $input['projectstatus'];
      if(array_key_exists('completed', $input)) $project_data['completed'] = $input['completed'];

      if(Account::checkTeamManager($id) == true || $project['created_by'] == $user->id){
        if(array_key_exists('share', $input)) $project_data['share'] = $input['share'];
        if(array_key_exists('active', $input)) $project_data['active'] = $input['active'];
        if(array_key_exists('email', $input)) $project_data['email'] = $input['email'];
        if(array_key_exists('besttimetocall', $input)) $project_data['besttimetocall'] = $input['besttimetocall'];
        if(array_key_exists('hearaboutus', $input)) $project_data['hearaboutus'] = $input['hearaboutus'];
        if(array_key_exists('howcanwehelp', $input)) $project_data['howcanwehelp'] = $input['howcanwehelp'];
      }
      $res = Project::find($id)->update($project_data);
      $project = Project::with('person')->with('projectDetails')->find($id);
      $person = Person::with('phones')->with('addresses')->find($project['person']['id']);
      $res = $project;
      unset($res['person']);
      $res['person'] = $person;
      $response = $project;
      return $response;
    }

    public function list(Request $request)
    {
      $user = auth()->user();
      $input = $request->all();
      $projects = Project::where('created_by', $user->id)
          ->with('person')
          ->with('projectDetails')
          ->where('projectstatus', $input['projectstatus'])
          ->where('active', $input['active'])->get();
      $response = $projects;
      return $projects;
    }

    public function leads($active)
    {
      $user = auth()->user();
      $projects = Project::where('created_by', $user->id)
          ->where('active',$active)->with('person')->get();
      $response = $projects;
      return $projects;
    }

    public function show($id)
    {
      $project = Project::with('person')->with('projectDetails')->find($id);
      $person = Person::with('phones')->with('addresses')->find($project['person']['id']);
      $res = $project;
      unset($res['person']);
      $res['person'] = $person;
      return $res;
    }

    public function destroy($id)
    {
      $project = Project::find($id);
      $projectdetails = ProjectDetail::where('projectid', $project['id'])->get();
      foreach($projectdetails as $projectdetail){
          $projectdetailstyles = ProjectDetailStyle::where('projectdetailid', $projectdetail['id'])->get();
          foreach($projectdetailstyles as $projectdetailstyle) $projectdetailstyle->delete();
          $projectdetail->delete();
      }
      $project->delete();
      $project['projectdetails'] = $projectdetails;
      return $project;
    }
}
