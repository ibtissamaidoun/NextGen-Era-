<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\animateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AnimateurCreated;

class AnimateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animateurs = User::where('role','animateur')->get();//->select('id','nom','prenom')->get();

        return response()->json([$animateurs]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
            ],
        ]);

        DB::beginTransaction();
        try {
            // Generate a random password
            $randomPassword = Str::random(10);

            // Extract the first part of the email to use as the default name
            $emailParts = explode('@', $request->email);
            $defaultNom = $emailParts[0]; // Use the part before the "@" as the default name
            $defaultPrenom = 'DefaultSurname'; // Example default surname
            $defaultTelephonePortable = '0700000000'; // Example default mobile phone
            $defaultTelephoneFixe = '0500000000'; // Example default landline phone
            $defaultDomaineCompetence = 'General'; // Example default domain of competence

            $user = User::create([
                'nom' => $defaultNom,
                'prenom' => $defaultPrenom,
                'email' => $request->email,
                'telephone_portable' => $defaultTelephonePortable,
                'telephone_fixe' => $defaultTelephoneFixe,
                'mot_de_passe' => Hash::make($randomPassword),
                'role' => 'animateur'  // Automatically assign the role of 'animateur'
            ]);

            $animateur = new animateur([
                'user_id' => $user->id,
                'domaine_competence' => $defaultDomaineCompetence
            ]);
            $animateur->save();

            // Send the random password by email
            Mail::to($request->email)->send(new AnimateurCreated($user, $randomPassword));

            DB::commit();
            return response()->json([
                'id' => $animateur->id,
                'user_id' => $user->id,
                'message' => 'Animateur created successfully and password sent by email'
            ]);
        } catch(\Exception $e){
            DB::rollback();

            // and return an error message
            return response()->json(['message' => 'Failed to create animateur: ' . $e->getMessage()], 409);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animateur = User::where('role', 'animateur')
                         ->where('id', $id)
                         ->with(['animateur.horaires']) // Corrected the relationship paths
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
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:users,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
            ],
            'telephone_portable' => [
                'sometimes',
                'required',
                'regex:/^(06|07)[0-9]{8}$/i', // format validation
            ],
            'telephone_fixe' => [
                'sometimes',
                'nullable',
                'regex:/^05[0-9]{8}$/i', // format validation
            ],
            'domaine_competence' => 'sometimes|required|string',
        ]);


        DB::beginTransaction();
        try {
            // Update user information
            $userData = $request->only(['nom', 'prenom', 'email', 'telephone_portable', 'telephone_fixe']);
            $user->update($userData);

            // Update the domaine competence if provided
            if ($request->has('domaine_competence')) {
                $animateur = animateur::where('user_id', $id)->firstOrFail();
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

    public function updatePassword(Request $request, $id)
    {
        $user = User::where('role', 'animateur')->findOrFail($id);

        $request->validate([
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'mot_de_passe' => Hash::make($request->mot_de_passe),
            ]);

            DB::commit();

            return response()->json(['message' => 'Password updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update password: ' . $e->getMessage()], 409);
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
