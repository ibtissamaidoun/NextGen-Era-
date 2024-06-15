<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\demande;
use App\Mail\AdminCreated;
use Illuminate\Support\Str;
use App\Models\notification;
use Illuminate\Http\Request;
use App\Models\administrateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            'email' => [
                'required',
                'email',
               // 'unique:users,email',
               // 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
            ],
        ]);

        DB::beginTransaction();
        try {
            // Generate a random password
            $randomPassword = Str::random(10);

            // Extract the first part of the email to use as the default name
            $emailParts = explode('@', $request->email);
            $defaultNom = $emailParts[0]; // Use the part before the "@" as the default name
            $defaultPrenom = $emailParts[0]; // Example default surname
            $defaultTelephonePortable = '0700000000'; // Example default mobile phone
            $defaultTelephoneFixe = '0500000000'; // Example default landline phone
            $role = 'admin';

            $user = User::create([
                'nom' => $defaultNom,
                'prenom' => $defaultPrenom,
                'email' => $request->email,
                'telephone_portable' => $defaultTelephonePortable,
                'telephone_fixe' => $defaultTelephoneFixe,
                'mot_de_passe' => Hash::make($randomPassword),
                'role' => $role  // Automatically assign the role of 'admin'
            ]);
            $administrateur = new administrateur([
                'user_id'=> $user->id
            ]);
            $administrateur->save();

            // Send the random password by email
            Mail::to($request->email)->send(new AdminCreated($user, $randomPassword));

            DB::commit();
            return response()->json([
                'id'=>$administrateur->id,
                'user_id'=>$user->id,
                'message'=>'Admin created successfully'
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
    $demandes = Demande::where('statut', $status)
                        ->with('parentmodel.user', 'offre', 'paiement')
                        ->get();
    
    $filteredDemandes = $demandes->map(function ($demande) {
        return [
            'id' => $demande->id,
            'parent_name' => $demande->parentmodel->user->nom . ' ' . $demande->parentmodel->user->prenom,
            'date_demande' => $demande->created_at->format('d/m/Y'),
            'statut' => $demande->statut,
            'offre_titre' => $demande->offre ? $demande->offre->titre : null,
            'paiement_option' => $demande->paiement ? $demande->paiement->option_paiement : null,
        ];
    });
    
    dd($filteredDemandes); // Vérifiez la structure de $filteredDemandes ici
    
    return response()->json(['demandes' => $filteredDemandes]);
}
   //taha naya has deleted this useless code 

}
