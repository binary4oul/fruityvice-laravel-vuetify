<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Models\Project;
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

  public function sendmail($id) {
		$response['status'] = 'success';
		$project = Project::with('person')->with('projectDetails')->find($id);
		$projectdetails = $project['projectDetails'];
		$estimateprice = 0;
		foreach($projectdetails as $details) $estimateprice += $details['areaprice'];
		$project['price'] = $estimateprice;

		$contracttemplate = ContractTemplate::where('created_by', $project->created_by)->first();
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

		$project['contracttemplate'] = $contracttemplate;
		$project['images'] = $this->ProjectImageController->list($id);
		$project['notes'] = $this->ProjectNoteController->list($id);

		// $images_url = array();
		// foreach($project['images'] as $image) {
		// 	$image_data['image'] = 'http://dev.myincredibleone.com/storage/images/1603738094.png';
		// 	array_push($images_url, $image_data);
		// }
		// $project['images'] = $images_url;

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
