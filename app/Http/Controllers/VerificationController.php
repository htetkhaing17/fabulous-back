<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{  
    public function verify(Request $reqeust){
        $user = User::findOrFail($reqeust->id);
        $user->markEmailAsVerified();
        return redirect(env('SPA_URL'));
    }

    public function resend(Request $request)
    {
        dd($request->email);
        $user = User::where('email',$request->email)->firstOrFail();
        $user->sendEmailVerificationNotification();
        return response()->json(['message','resent verification email'], 200);
    }
}
