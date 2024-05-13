<?php

namespace App\Http\Controllers;

use App\Models\parentmodel;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // verification que email et password sont entré et validé
        $fields = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|string'
        ]);

        //recherge de user qui correspond au email entré
        $user = User::where('email',$fields['email'] )->first();
        //si email invalide ou mot de passe haché ne correspond pas au mot de passe entré
        //! Auth::attempt($fields)
        if ( !$user || !Hash::check($fields['mot_de_passe'], $user->mot_de_passe))
        {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('MyAppToken')->plainTextToken;//généeration de token
        return response()->json([
            'token' => $token,
            'role' => $user->role, // Ajoutez cette ligne
        ],202);//renvoyer les données au client
    }
    public function register(Request $request){
        DB::beginTransaction();
        try {
            $fields = $request->validate([
                'nom'=>'required|string',
                'prenom'=>'required|string',
                'telephone_portable' => 'required|regex:/^0[67]\d{8}$/',
                'telephone_fixe' => 'required|regex:/^0[5]\d{8}$/',
                'email' => 'required|email',
                'mot_de_passe' => 'required|string|confirmed',
                'fonction' => 'nullable|string'
            ]);

            $user = User::create([
                'nom' => $fields['nom'],
                'prenom' => $fields['prenom'],
                'telephone_portable' =>$fields['telephone_portable'],
                'telephone_fixe' =>$fields['telephone_fixe'],
                'email' =>$fields['email'],
                'mot_de_passe' => Hash::make($fields['mot_de_passe']),
            ]);
            $parent= new parentmodel([
                'fonction'=>$request->fonction,
                'user_id'=> $user->id
            ]);
            $parent->save();
            DB::commit();
            $token = $user->createToken('MyAppToken')->plainTextToken;
            return response()->json(['token' => $token],202);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            // Supprimer les tokens de l'utilisateur
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
            // retourner une réponse JSON pour une API
            return response()->json(['message' => 'Logged out successfully'], 200);
        }
    }

    public function userProfile(){
        return response()->json(auth()->user());

    }




}