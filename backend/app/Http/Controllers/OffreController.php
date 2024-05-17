<?php

namespace App\Http\Controllers;

use App\Models\offre;
use App\Models\Activite;
use App\Models\paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offres= offre::select('id','titre','remise','date_debut_inscription','date_fin_inscription')->get();
        return response()->json(['offre'=>$offres]);
    }


    public function show($id)
    {
        $offre = offre::with('getActivites.horaires')->find($id);
        return response()->json([$offre]);
    }

    /**
     * Store a newly created resource in storage.
     */
  //this function woriks well dont touch it , at first only i and god knows how it works , now only god knows .
  //remember if an error occurs , its propably the admin_id or other id
    
   
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $offre = offre::find($id);
        if(!$offre)
        {
            return response()->json(['message'=>'offre non trouve'],404);
        
        }
    +    $offre->delete();
        return response()->json(['message'=>'offre deleted successfuly']);
    }

//     public function attachactivity(Request $request, $offerId)
// {
//     $offer = offre::find($offerId);


//     $validatedata= $request->validate([
//         'activite_id'=>'required|exists:activites,id',
//     ]);


//     $activite = Activite::find($validatedata['activite_id']);

//     $offer->getActivites()->attach($activite->id);
// }


// public function detachActivity(Request $request, $offerId)
// {
//     // Find the offer by its ID
//     $offer = Offre::find($offerId);
    

//     // Validate the incoming request data to ensure activite_id is provided and valid
//     $validatedData = $request->validate([
//         'activite_id' => 'required|exists:activites,id',
//     ]);

    
//     // Find the activity by its ID
//     $activite = Activite::find($validatedData['activite_id']);
    
//     // Check if the activity is currently associated with the offer
//     if ($offer->getActivites()->find($activite->id)) {
//         // Detach the activity from the offer
//         $offer->getActivites()->detach($activite->id);
//         return response()->json(['message' => 'Activity detached successfully from the offer']);
//     } else {
//         return response()->json(['message' => 'This activity is not associated with the specified offer'], 404);
//     }
// }
// admin id should be returned by the user authentification admin
public function store(Request $request)
{
    try {
        // Validate incoming request
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'remise' => 'nullable|integer|min:0|max:100',
            'date_debut_inscription' => 'required|date',
            'date_fin_inscription' => 'required|date|after_or_equal:date_debut_inscription',


          //  'administrateur_id' => 'required|exists:administrateurs,id',

            'paiement_id' => 'required|exists:paiements,id',
            'activites' => 'required|array',
            'activites.*.id' => 'exists:activites,id', // Ensure each activity ID exists
        ]); 

        // Create the new offer
        $offer = new Offre([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'remise' => $validated['remise'],
            'date_debut_inscription' => $validated['date_debut_inscription'],
            'date_fin_inscription' => $validated['date_fin_inscription'],
            'administrateur_id' => $validated['administrateur_id'],
        ]);
        $offer->save();

        // Attach activities to the offer with pivot data
        foreach ($validated['activites'] as $activity) {
            $offer->getActivites()->attach($activity['id'], ['paiement_id' => $validated['paiement_id']]);
        }
        
        // Return success response
        return response()->json(['message' => 'Offer created successfully', 'offer' => $offer], 201);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error while creating offer: ' . $e->getMessage());

        // Return error response
        return response()->json(['message' => 'Failed to create offer', 'error' => $e->getMessage()], 500);
    }
}
public function update(Request $request, $offerId)
{
    try {
        // Find the offer by its ID
        $offer = Offre::findOrFail($offerId);
        
        // Validate incoming request
        $validated = $request->validate([
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'remise' => 'nullable|integer|min:0|max:100',
            'date_debut_inscription' => 'sometimes|required|date',
            'date_fin_inscription' => 'sometimes|required|date|after_or_equal:date_debut_inscription',
            'administrateur_id' => 'sometimes|required|exists:administrateurs,id',
            'paiement_id' => 'sometimes|required|exists:paiements,id',
            'activites' => 'sometimes|required|array',
            'activites.*.id' => 'exists:activites,id', // Ensure each activity ID exists
        ]);


        // Update the offer's attributes
        $offer->titre = $validated['titre'];
        $offer->description = $validated['description'];
        $offer->remise = $validated['remise'];
        $offer->date_debut_inscription = $validated['date_debut_inscription'];
        $offer->date_fin_inscription = $validated['date_fin_inscription'];
        $offer->administrateur_id = $validated['administrateur_id'];
        $offer->save();

        // Detach all existing activities from the offer
        $offer->getActivites()->detach();

        // Attach updated activities to the offer with pivot data
        foreach ($validated['activites'] as $activity) {
            $offer->getActivites()->attach($activity['id'], ['paiement_id' => $validated['paiement_id']]);
        }
        
        // Return success response
        return response()->json(['message' => 'Offer updated successfully', 'offer' => $offer]);
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Error while updating offer: ' . $e->getMessage());

        // Return error response
        return response()->json(['message' => 'Failed to update offer', 'error' => $e->getMessage()], 500);
    }
}

}
