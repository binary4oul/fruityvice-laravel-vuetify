<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admin() {
        return User::where('is_admin', 1)->first();
    }

    public function sendMailToAdmin($fruitName)
	{
		$admin = $this->admin();
		$user = auth()->user();

		$data = [
			'title' => 'Mail from Test Project.',
			'body' => $fruitName.' is added'
		];

		Mail::send('emails.testMail', $data, function ($message) use ($admin, $user) {
			$message->to($admin->email)->subject('Test Email');
			$message->from($user->email);
		});

		return 'Email sent successfully.';
	}
}
