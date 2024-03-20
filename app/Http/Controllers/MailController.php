<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'testing mail',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('testmail@yopmail.com')->send(new DemoMail($mailData));
           
        dd("Email is sent successfully.");
    }
}
