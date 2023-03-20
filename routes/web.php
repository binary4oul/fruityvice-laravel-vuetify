<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('{all}', function () {
    return view('app');
})->where(['all' => '.*']);

// Route::get('/api/send-email', function () {
//     $data = [
//         'title' => 'Mail from Laravel',
//         'body' => 'This is a test email from Laravel.'
//     ];

//     Mail::send('emails.testMail', $data, function ($message) {
//         $message->to('recipient@example.com')->subject('Laravel Test Email');
//     });

//     return 'Email sent successfully.';
// });
