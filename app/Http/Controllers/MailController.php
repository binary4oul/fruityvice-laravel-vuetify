<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Models\Project;
use App\Models\System;
use App\Models\ContractTemplate;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectNoteController;
use App\Http\Controllers\ProjectImageController;

class MailController extends Controller
{
		//

		protected $ProjectController, $ProjectImageController, $ProjectNoteController;
    public function __construct(ProjectController $ProjectController, ProjectNoteController $ProjectNoteController,ProjectImageController $ProjectImageController)
    {
				$this->ProjectController = $ProjectController;
				$this->ProjectNoteController = $ProjectNoteController;
				$this->ProjectImageController = $ProjectImageController;
		}

  public function sendmail(Request $request) {
		$response['status'] = 'success';
		$input = $request->all();
		$project = Project::with('person')->with('projectDetails')->find($input['project_id']);
		$projectdetails = $project['projectDetails'];
		$estimateprice = 0;
		foreach($projectdetails as $detail) {
			$system = System::where('id', $detail['system_id'])->first();
			$detail['system_name'] = $system['name'];
			$estimateprice += $detail['areaprice'];
		}
		$project['price'] = $estimateprice;

		$contracttemplate = ContractTemplate::where('created_by', $project->created_by)->where('id', $input['contract_id'])->first();
		if(!$contracttemplate)
		{
			$contracttemplate['name'] = '';
			$contracttemplate['logo'] = '';
			$contracttemplate['notetocustomer'] = '';
			$contracttemplate['scopeofwork'] = '';
			$contracttemplate['commoncondition'] = '';
			$contracttemplate['downpaymentterms'] = '';
			$contracttemplate['note'] = '';
			$contracttemplate['conclusion'] = '';
			$contracttemplate['footer'] = '';
		}
		if(empty($contracttemplate['notetocustomer'])) $contracttemplate['notetocustomer'] = '';
		if(empty($contracttemplate['scopeofwork'])) $contracttemplate['scopeofwork'] = '';
		if(empty($contracttemplate['commoncondition'])) $contracttemplate['commoncondition'] = '';
		if(empty($contracttemplate['downpaymentterms'])) $contracttemplate['downpaymentterms'] = '';
		if(empty($contracttemplate['note'])) $contracttemplate['note'] = '';
		if(empty($contracttemplate['conclusion'])) $contracttemplate['conclusion'] = '';

		$project['contracttemplate'] = $contracttemplate;

		if(!$project['email']) {
			$response['status'] = 'error';
			$response['message'] = "Input Email Address on 'LeadDetail'";
			return $response;
		}

		$data = [
				'title' => 'Mail from Contractor.',
				'body' => 'This is your Estimate.',
				'client_name' => $project['person']['firstname'],
				'to' => $project['email']
		];

		$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('emails.pdf', $project);

		Mail::send('emails.testMail', $data, function($message)use($data, $pdf) {
			$message->to($data['to'], $data['client_name'])
						->subject("subject")
						->attachData($pdf->output(), "Estimate.pdf");
			});

			return $response;

		}
}
