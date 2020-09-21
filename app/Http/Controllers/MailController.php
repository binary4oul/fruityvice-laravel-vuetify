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

    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");

        Mail::send(['text'=>'mail'], $data, function($message) {
           $message->to('sweetfigaro27@gmail.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('sweetfigaro27@gmail.com','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
     }
}
