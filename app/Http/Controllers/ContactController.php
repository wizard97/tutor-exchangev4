<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
  public function index()
  {
    return view('contact');
  }

  public function send(Request $request)
  {
    $this->validate($request, [ //verify form validity
      'name' => 'required|max:50|string',
      'subject' => 'required|max:50|string',
      'email' => 'required|email',
      'message' => 'required|string|max:1000',
    ]);
    $inputs = $request->all(); //store input
    //send email
    \Mail::queue('emails.contactus', array('email_message' => $inputs['message']), function($message) use ($inputs) {
      $message->to('lextutorexchangecontact@gmail.com', 'LexTutor Contact')
      ->subject($inputs['subject'])
      ->from('no-reply@lextutorexchange.com','Lexington Tutor Exchange')
      ->replyTo($inputs['email'], $inputs['name']);
    });
    \Session::put('feedback_positive', 'Your message has been sent, we will respond as soon as we can.');
    return redirect(route('contact.index'));
  }
}
