<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\TokenAbility;
use App\Models\parentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.expiration')));
$refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));
        return response()->json([
            'token' => $token->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'role' => $user->role, // Ajoutez cette ligne
            'utilisateur' => $user
        ],202);//renvoyer les données au client
    }
    public function register(Request $request){
        DB::beginTransaction();
        try {
            $fields = $request->validate([
                'nom'=>'required|string',
                'prenom'=>'required|string',               
                'telephone_fixe' => 'required|regex:/^0[5]\d{8}$/',
                'email' => 'required|email',
                'mot_de_passe' => 'required|string|confirmed',
                'fonction' => 'nullable|string',
                'telephone_portable' => 'required|regex:/^0[67]\d{8}$/'
            ]);

            $user = User::create([
                'nom' => $fields['nom'],
                'prenom' => $fields['prenom'],
                'telephone_portable' =>$fields['telephone_portable'],
                'telephone_fixe' =>$fields['telephone_fixe'],
                'email' =>$fields['email'],
                'mot_de_passe' => Hash::make($fields['mot_de_passe'])
            ]);
            $parent= new parentmodel([
                'fonction'=>$request->fonction,
                'user_id'=> $user->id
            ]);
            $parent->save();
            DB::commit();
            $token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.expiration')));
            $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

            return response()->json([
                'token' => $token->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken
            ], 202);
        }
        catch (\Throwable $th) {
            DB::rollback(); 
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

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $accessTokenExpiration = config('sanctum.expiration');

        if (!$accessTokenExpiration) {
           return response()->json(['message' => 'Token expiration time not configured'], 500);
        }
        $accessTokenExpiresAt = Carbon::now()->addMinutes($accessTokenExpiration);

        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], $accessTokenExpiresAt);

        return response()->json(['token' => $accessToken->plainTextToken]);
    }

    public function userProfile(){
        return response()->json(auth()->user());

    }




}