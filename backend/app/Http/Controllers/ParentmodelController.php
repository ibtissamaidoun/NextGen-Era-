<?php

namespace App\Http\Controllers;

use App\Models\horaire;
use App\Models\User;
use App\Models\offre;
use App\Models\parentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentmodelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = User::where('role','parent')->select('id','nom','prenom')->get();

        return response()->json([$parents]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validation des donnes
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => [
            'required',
            'email',
            'unique:users,email',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // Format validation
        ],
        'telephone_portable' => [
            'required',
            'regex:/^(06|07)[0-9]{8}$/i', // Format validation
        ],
        'telephone_fixe' => [
            'nullable',
            'regex:/^05[0-9]{8}$/i', // Format validation
        ],
        'mot_de_passe' => 'required|string|min:8',
        'fonction' => 'nullable|string',
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        // Create a new user
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone_portable' => $request->telephone_portable,
            'telephone_fixe' => $request->telephone_fixe,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => 'parent', // Assign the role of 'parent'
        ]);

        // Create a new parent model associated with the user
        $parent = new ParentModel([
            'fonction' => $request->fonction,
            'user_id' => $user->id,
        ]);
        $parent->save();

        // Commit the transaction
        DB::commit();

        // Return a success response
        return response()->json([
            'id' => $parent->id,
            'fonction' => $parent->fonction,
            'user_id' => $user->id,
            'message' => 'Parent created successfully'
        ]);
    } catch(\Exception $e) {
        // Rollback the transaction in case of an exception
        DB::rollback();

        // Return an error response with the error message
        return response()->json(['message' => 'Failed to create parent: ' . $e->getMessage()], 409);
    }
}
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $parent=User::where('role', 'parent')
        ->with('parentmodel')
        ->findOrFail($id);

return response()->json([$parent]);

    }

    
    /**
     * Update the specified resource in storage.
     */
   /**
 * Update the specified parent in the database.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(Request $request, $id)
{
    // Find the parent record by ID
    $user = User::where('role', 'parent')->findOrFail($id);

    // Validate the incoming request data
    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => [
            'required',
            'email',
            'unique:users,email,' . $user->id,
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // Format validation
        ],
        'telephone_portable' => [
            'required',
            'regex:/^(06|07)[0-9]{8}$/i', // Format validation
        ],
        'telephone_fixe' => [
            'nullable',
            'regex:/^05[0-9]{8}$/i', // Format validation
        ],
        'mot_de_passe' => 'nullable|string|min:8',
        'fonction' => 'nullable|string',
    ]);

    // Start a database transaction
    DB::beginTransaction();

    try {
        // Update user information
        $user->update($request->all());

        // Update password if provided
        if ($request->has('mot_de_passe')) {
            $user->mot_de_passe = Hash::make($request->mot_de_passe);
            $user->save();
        }

        // Update parent's additional attributes
        if ($request->has('fonction')) {
            $parent = ParentModel::where('user_id', $user->id)->firstOrFail();
            $parent->fonction = $request->fonction;
            $parent->save();
        }

        // Commit the transaction
        DB::commit();

        // Return a success response
        return response()->json(['message' => 'Parent updated successfully']);
    } catch (\Exception $e) {
        // Rollback the transaction in case of an exception
        DB::rollback();

        // Return an error response with the error message
        return response()->json(['message' => 'Failed to update parent: ' . $e->getMessage()], 409);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('role', 'parent')->findOrFail($id)->delete();
        return response()->json(['message' => 'parent deleted successfully']);
    }


    //taha partie 
    public function getoffers()
    {
        $user = Auth::user();
        $offers = offre::all();
        $enfant = $user->parentmodel->enfants;
     
        return response()->json(['offres'=>$offers, 'enfant'=>$enfant]);
    
    }

    public function showoffer($id)
    {
        $user = Auth::user();
        $offer = offre::findorfail($id);
        $enfant = $user->parentmodel->enfants;
        $paiement = $offer->paiement;
        $activities = $offer->activites;
        $horaires = $activities->pluck('horaires')->flatten();
        return response()->json(['offres'=>$offer, 'enfant'=>$enfant, 'paiement'=>$paiement, 'activities'=>$activities, 'horaires'=>$horaires]);
    }

    /**
     * Display the edt for the choosen child
    */
    public function EDT($enfant_id)
    {
        $user = Auth::user();
        $parent = $user->parentmodel;
        
        // Retrieve the enfant_id from the request
        $child = $parent->enfants()->find($enfant_id);
        $activites = $child->activites()->select(['id','titre'])->get();
        $data = [];
        foreach($activites as $activite)
        {
            $horaires = [horaire::find($activite->pivot->horaire_1),
                         horaire::find($activite->pivot->horaire_2)];
            foreach($horaires as $horaire)
            {
                $animateur = $activite->getAnimateurs()->where('horaire_id',$horaire->id)->first();
                $user = $animateur->user;

                $data[] = [
                    'activite' => $activite->titre,
                    'animateur' => $user->nom.' '.$user->prenom,
                    'jour_semaine' => $horaire->jour_semaine,
                    'heure_debut' => $horaire->heure_debut,
                    'heure_fin' => $horaire->heure_fin,
                ];
            }
        }
        // Send the data to the parent
        return response()->json(['child_activities' => $data]);
    }

}
