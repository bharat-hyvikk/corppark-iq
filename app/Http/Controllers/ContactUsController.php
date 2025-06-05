<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
          // validate 
          $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'message' => 'required',
        ]);
         $email = 'info@carrental.com';
        Mail::to($email)->send(new ContactUs($request));
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
