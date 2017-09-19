<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function contactFormEmail(Request $request)
    {
        $email = new Email();
        $email->name = $request->name;
        $email->email = $request->email;
        $email->message = $request->message;
        $email->save();
        
        Mail::send(new \App\Mail\Contact($email));
        
        return response()->json(['success' => true,
                                'message' => 'email sent']);
    }

    public function passwordRecovery(Request $request)
    {
        $user = User::findUserByEmail($request->email);

        if (!$user->exists()) {
            return response()->json(['success' => false,
                                    'error' => 'user not registered']);
        }
        
        if ($user->email == null) {
            return response()->json(['success' => false,
                                    'error' => 'user with email not registered']);
        }
        
        Mail::send(new \App\Mail\PasswordRecovery($user->email));
    }
}
