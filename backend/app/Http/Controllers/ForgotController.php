<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
class ForgotController extends Controller
{
    
    public function forget(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $fields['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }
        $email=$fields['email'];
        $token = Str::random(60); //genere une chaine de caractere difficile a deviner 
        DB::table('password_reset_tokens')->updateOrInsert(['email' => $email], [ //updateOrInsert qui garantit que chaque email n'a qu'un seul token actif à la fois
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ]);
        Mail::send('emails.reset', ['token' => $token], function($message) use ($email) {
            $message->to($email);
            $message->subject('Reset your password');
        });
        return response()->json(['message' => 'Reset link sent to your email address',
                                 'token' => $token],202);
    }
    
    public function reset(Request $request) {
        $fields = $request->validate([
            'mot_de_passe'=> 'required|string|confirmed'
        ]);
        $token = $request->input('token');
        $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!$passwordReset) {
            return response()->json(['message'=> 'invalid token'],404);
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return response()->json(['message'=> 'user not found'],404);
        }//cheker juste le token , car email je suis sur qu'existe 
        DB::transaction(function () use ($user, $fields, $token) {
         $user->mot_de_passe = bcrypt($fields['mot_de_passe']);
         $user->save();
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        });
        return response()->json(['message'=> 'Your password is reset successfully'],202);

}

}