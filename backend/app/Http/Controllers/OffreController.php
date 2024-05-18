<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Activite;
use App\Models\Administrateur;
use App\Models\Paiement;
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
        $offres = Offre::select('id', 'titre', 'remise', 'date_debut', 'date_fin')->get();
        return response()->json(['offre' => $offres]);
    }

    public function show($id)
    {
        $offre = Offre::with('activites.horaires')->find($id);
        return response()->json([$offre]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $offre = Offre::find($id);
        if (!$offre) {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
        $offre->delete();
        return response()->json(['message' => 'Offre deleted successfully']);
    }

<<<<<<< HEAD
    public function attachactivity(Request $request, $offerId)
{
    $offer = offre::find($offerId);

    $validatedata= $request->validate([
        'activite_id'=>'required|exists:activites,id',
    ]);

    $activite = Activite::find($validatedata['activite_id']);

    $offer->getActivites()->attach($activite->id);
}


public function detachActivity(Request $request, $offerId)
{
    // Find the offer by its ID
    $offer = Offre::find($offerId);
    
    // Validate the incoming request data to ensure activite_id is provided and valid
    $validatedData = $request->validate([
        'activite_id' => 'required|exists:activites,id',
    ]);
    
    // Find the activity by its ID
    $activite = Activite::find($validatedData['activite_id']);
    
    // Check if the activity is currently associated with the offer
    if ($offer->getActivites()->find($activite->id)) {
        // Detach the activity from the offer
        $offer->getActivites()->detach($activite->id);
        return response()->json(['message' => 'Activity detached successfully from the offer']);
    } else {
        return response()->json(['message' => 'This activity is not associated with the specified offer'], 404);
    }
}

public function store(Request $request)
{
    try {
        // Validate incoming request
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'remise' => 'nullable|integer|min:0',
            'date_debut_inscription' => 'required|date',
            'date_fin_inscription' => 'required|date|after_or_equal:date_debut_inscription',
          //  'administrateur_id' => 'required|exists:administrateurs,id',
            'paiement_id' => 'required|exists:paiements,id',
            'activites' => 'required|array',
            'activites.*.id' => 'exists:activites,id', // Ensure each activity ID exists
        ]); 
=======


>>>>>>> b0ff42eb0fd2d42c21dff1a6dd22cc85a9510d33

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'remise' => 'nullable|integer|min:0',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'paiement_id' => 'required|exists:paiements,id',
                'activites' => 'required|array',
                'activites.*.id' => 'exists:activites,id',
            ]);

            $user = $request->user();
            $admin = Administrateur::where('user_id', $user->id)->first();

            $offer = new Offre([
                'titre' => $validated['titre'],
                'description' => $validated['description'],
                'remise' => $validated['remise'],
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'paiement_id' => $validated['paiement_id'],
                'administrateur_id' => $admin->id,
            ]);
            $offer->save();

            foreach ($validated['activites'] as $activity) {
                $offer->activites()->attach($activity['id']);
            }

            return response()->json(['message' => 'Offer created successfully', 'offer' => $offer], 201);
        } catch (\Exception $e) {
            Log::error('Error while creating offer: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create offer', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $offerId)
{
    try {
        $offer = Offre::findOrFail($offerId);

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'remise' => 'nullable|integer|min:0',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'paiement_id' => 'sometimes|exists:paiements,id',
            'activites' => 'sometimes|array',
            'activites.*.id' => 'exists:activites,id',
        ]);

        $offer->update($validated);

        // Sync activities
        if (isset($validated['activites'])) {
            $activityIds = array_column($validated['activites'], 'id');
            $offer->activites()->sync($activityIds);
        } else {
            $offer->activites()->detach(); // Detach all if no activities are provided
        }

        return response()->json(['message' => 'Offer updated successfully', 'offer' => $offer]);
    } catch (\Exception $e) {
        Log::error('Error while updating offer: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to update offer', 'error' => $e->getMessage()], 500);
    }
}
}