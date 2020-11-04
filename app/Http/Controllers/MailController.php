<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PDF;

class MailController extends Controller
{
    //
    public function test(){
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        \Mail::to('sweetfigaro27@gmail.com')
            ->send(new \App\Mail\TestMail($details));

        dd("Email is Sent.");
    }

    public function sendmail() {
        $response = 'ok';

        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        $data['details'] = $details;

        $pdf = PDF::loadView('emails.pdf', $data);

        // \Mail::to('sweetfigaro27@gmail.com')
        //     ->send(new \App\Mail\TestMail($details))
        //     ->attachData($pdf->output(), "invoice.pdf");

      Mail::send('emails.testMail', $data, function($message)use($data, $pdf) {
        $message->to('sweetfigaro27@gmail.com', "client_name")
              ->subject("subject")
              ->attachData($pdf->output(), "invoice.pdf");
        });

        return $response;

        dd("Email is Sent.");
     }
}
