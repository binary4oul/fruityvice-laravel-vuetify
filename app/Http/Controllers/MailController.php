<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    //
    public function test(){
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        \Mail::to('sweetfigaro27@gmail.com')->send(new \App\Mail\TestMail($details));

        dd("Email is Sent.");
    }

    public function sendmail() {
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        \Mail::to('sweetfigaro27@gmail.com')->send(new \App\Mail\TestMail($details));

        dd("Email is Sent.");
     }
}
