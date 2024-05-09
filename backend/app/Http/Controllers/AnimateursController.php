<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\animateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnimateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animateurs = User::where('role','animateur')->select('id','nom','prenom')->get();

        return response()->json([$animateurs]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => [
                'required',
                'email',
                'unique:users,email',
               'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
            ],
            'telephone_portable' => [
                'required',
                'regex:/^(06|07)[0-9]{8}$/i', // format validation
            ],
            'telephone_fixe' => [
                'nullable',
                'regex:/^05[0-9]{8}$/i', // format validation
            ],
            'mot_de_passe' => 'required|string|min:8',
            'domaine_competence'=>'required|string',

        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone_portable' => $request->telephone_portable,
                'telephone_fixe' => $request->telephone_fixe,
                'mot_de_passe' => Hash::make($request->mot_de_passe),
                'role' => 'animateur'  // Automatically assign the role of 'animateur'

            ]);
            $animateur= new animateur([
                'domaine_competence'=>$request->domaine_competence,
                'user_id'=> $user->id
            ]);
            $animateur->save();
            DB::commit();
            return response()->json([
                'id'=>$animateur->id,
                'user_id'=>$user->id,
                'message'=>'Animateur created successfulyy'
            ]);
    } catch(\Exception $e){
        DB::rollback();

        // and return an error message
        return response()->json(['message' => 'Failed to create admin: ' . $e->getMessage()], 409);
    }
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animateur = User::where('role', 'animateur')
        ->where('id', $id)
        ->with(['animateur.horaires', 'animateur.gethoraires']) // Adjusted the relationship paths
        ->first();

if (!$animateur) {
return response()->json(['message' => 'Animateur not found'], 404);
}

return response()->json($animateur);
    
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::where('role', 'animateur')->findOrFail($id);

    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => [
            'required',
            'email',
            'unique:users,email,' . $user->id,
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
        ],
        'telephone_portable' => [
            'required',
            'regex:/^(06|07)[0-9]{8}$/i', // format validation
        ],
        'telephone_fixe' => [
            'nullable',
            'regex:/^05[0-9]{8}$/i', // format validation
        ],
        'mot_de_passe' => 'nullable|string|min:8',
        'domaine_competence' => 'required|string',
    ]);

    DB::beginTransaction();
    try {
        // Update user information
        $userData = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone_portable' => $request->telephone_portable,
            'telephone_fixe' => $request->telephone_fixe,
        ];

        // Update password if provided
        if ($request->has('mot_de_passe')) {
            $userData['mot_de_passe'] = Hash::make($request->mot_de_passe);
        }

        $user->update($userData);

        // Update the domaine competence
        if ($request->has('domaine_competence')) {
            $animateur = animateur::where('user_id', $id)->firstorfail();
            $animateur->update(['domaine_competence' => $request->domaine_competence]);
        }

        DB::commit();

        return response()->json(['user' => $user, 'message' => 'Animateur updated successfully']);
    } catch (\Exception $e) {
        DB::rollback();

        // Return an error message
        return response()->json(['message' => 'Failed to update animateur: ' . $e->getMessage()], 409);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('role', 'animateur')->findOrFail($id)->delete();
        return response()->json(['message' => 'Animateur deleted successfully']);
    }
}
