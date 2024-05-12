<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\administrateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\demande;
use App\Models\notification;

class AdministrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->select('id', 'nom', 'prenom')->get();
                      
         return response()->json($admins)    ;         
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
            'mot_de_passe' => 'required|string|min:6|confirmed',

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
                'role' => 'admin'  // Automatically assign the role of 'admin'

            ]);
            $administrateur = new administrateur([
                'user_id'=> $user->id
            ]);
            $administrateur->save();

            DB::commit();
            return response()->json([
                'id'=>$administrateur->id,
                'user_id'=>$user->id,
                'message'=>'Admin created successfulyy'
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
        $admin = User::where('role','admin')->with('administrateur')
        ->findorfail($id);
        return response()->json([
        $admin
        ]);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
{
    $user = User::where('role', 'admin')->findOrFail($id);
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => [
            'required',
            'email',
            'unique:users,email,' . $user->id, // Exclude the current user ID from unique check
          //  'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
        ],
        'telephone_portable' => [
            'required|regex:/^0[67]\d{8}$/',
         //   'regex:/^(06|07)[0-9]{8}$/i', // format validation
        ],
        'telephone_fixe' => [
            'nullable|regex:/^0[5]\d{8}$/',
        //    'regex:/^05[0-9]{8}$/i', // format validation
        ],
        'mot_de_passe' => 'nullable|string|min:8|confirmed',
    ]);

    DB::beginTransaction();
    try {
       
        // Update the user information
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone_portable' => $request->telephone_portable,
            'telephone_fixe' => $request->telephone_fixe,
        ]);

        // Update the password if provided
        if ($request->has('mot_de_passe')) {
            $user->mot_de_passe = Hash::make($request->mot_de_passe);
            $user->save();
        }

        DB::commit();
        return response()->json([
            'user'=>$user,
            'message' => 'Admin updated successfully'
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Failed to update admin: ' . $e->getMessage()], 409);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('role', 'admin')->findOrFail($id)->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }

    public function getdemandes()
    {
        $status = 'en cours';
        $demandes = demande::where('statut', $status)->get();
        
        // Loop through each demande to fetch additional related data
        $filteredDemandes = $demandes->map(function ($demande) {
            return [
                'id' => $demande->id,
                'paiement_option' => $demande->paiement->option_paiement ?? null,
                'offer_titre' => $demande->offre->titre ?? null,
                'parent_name' => $demande->parentmodel->user->nom ?? null,
            ];
        });
        
        // Return the modified demandes with additional data
        return response()->json(['demandes' => $filteredDemandes]);
        
    }

    public function validated(Demande $demande)
{
    // Update demande status to validated
    $demande->update(['statut' => 'valide']);


   
    // Retrieve parent associated with the demande
    $parent = $demande->parentmodel->user;

    // Enroll children in activities
    $activities = $demande->offre->activities;
    foreach ($activities as $activity) {
        $activity->enrollChildren($parent->children);
    }

    // Return success response
    return response()->json(['message' => 'Demande validated successfully']);
}
public function refuse(Demande $demande)
{
    // Update demande status to refused
    $demande->update(['statut' => 'refuse']);
    $parent = $demande->parentmodel->user;

    // Create a notification for the parent
    notification::create([
        'type' => 'demande_refused',
        'statut' => 'non lu',
        'contenu' => 'Your demande has been refused.',
    ]);

    // Attach the notification to the parent
    $parent->notifications()->attach(notification::latest()->first()->id);

    // Return success response
    return response()->json(['message' => 'Demande refused successfully']);
}
}
