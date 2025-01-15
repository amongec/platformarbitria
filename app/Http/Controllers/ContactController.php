<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function index(){
      return view ('contact.index')->with('info', 'Message send.');
   }

   public function store(Request $request)
   {

      $request->validate([
         'name'=> 'required',
         'email'=> 'required|email',
         'message'=> 'required',
      ]);

      $email = new ContactUsMailable($request->all());
      Mail::to('gruproscat@gmail.com')
         ->send($email);

        //->flash('info', 'Message send');
      return redirect()->route('contact.index')
        ->with('info', 'Message send');
   }
}
