<?php

namespace App\Http\Controllers;

use App\Mail\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EmailFns extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function submitEmail(Request $request)
    {

        //Mail::to($request->recipient)->send(new EmailTemplate($request->subject,$request->content));

        $recipient = $request->recipient;
        $subject = $request->subject;

        Mail::send('emailtemplate', $request->all(), function($message) use ($recipient,$subject){
            $message->to($recipient, "User")
                    ->subject($subject);
            $message->from('yourcapslock@gmail.com','Hans Marcon');
        });

        echo json_encode(['message' => 'Email Sent!']);

    }
}

