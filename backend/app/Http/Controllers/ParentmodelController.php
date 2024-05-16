<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\parentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\offre;

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
    $offers = offre::select('titre','id')->get();
    return response()->json(['offres'=>$offers]);
   
}

public function showoffer($id)
{
    $offer = offre::findorfail($id);
    return response()->json([$offer]);
}

}
