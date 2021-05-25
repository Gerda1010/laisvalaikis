<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\NotifyMailMail;
use Mail;

class SendEmailController extends Controller
{

//    public function sendEmail()
//    {
//
//        Mail::to('receiver-email-id')->send(new NotifyMail());
//
//        if (Mail::failures()) {
//            return response()->Fail('Sorry! Please try again latter');
//        }else{
//            return response()->success('Great! Successfully send in your mail');
//        }
//
//    }
    public function create()
    {

        return view('demoMail');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
//            'content1' => 'required',
        ]);

        $data = [
            'subject' => $request->subject,
            'email' => $request->email,
            'content1' => $request->content1
        ];

        Mail::send('email-template', $data, function($message) use ($data) {
            $message->to($data['email'])
                ->subject($data['subject']);
        });

        return back()->with(['message' => 'Email successfully sent!']);
    }
}
