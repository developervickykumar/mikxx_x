<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
class Mailcontroller extends Controller
{
    function sendMail(Request $request)
    {
       $to=$request->to;
         $msg=$request->msg;
       $subject=$request->sub;
    Mail::to($to)->send(new WelcomeEmail($msg,$subject));

    }
}
