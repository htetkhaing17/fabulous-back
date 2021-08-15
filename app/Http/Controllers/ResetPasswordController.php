<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PasswordUpdated;
use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{
    //

    public function request_code(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['message' => 'Invalid email.'], 422);
        }
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return response()->json(['message' => 'The two factor code has been sent again.'], 200);
    }

    public function verify_code(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user->two_factor_expires_at->lt(now())){
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode());
            
            return response()->json([
                'message' => 'The two factor code has expired. Request a new code.'
            ], 422);
        }

        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();
            return response()->json(['message' => 'ok'], 200);
        }

        return response()->json([
            'message' => 'The two factor code you have entered does not match.'
        ], 422);
           
    }


    public function reset_password(Request $request)
    {
        $user = User::where('email', $request->email)->first();  

        if($user){
            $user->update([
                'password' => Hash::make($request->newPassword)
            ]);

            $user->notify(new PasswordUpdated());
            return response()->json(['message'=>'OK'], 200);
        }

        return response()->json(['message' => 'something is wrong'], 422);

    }


}
