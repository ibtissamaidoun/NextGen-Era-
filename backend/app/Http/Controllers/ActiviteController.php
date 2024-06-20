<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use App\Models\Activite;
use App\Models\paiement;
use App\Models\animateur;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all activities
        $activities = Activite::select('id','titre','type_activite','domaine_activite','image_pub','tarif')->get();
        
        // Return JSON response with activities
        return response()->json($activities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            // Validation rules for activity fields
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'objectifs' => 'required|string',
            'image_pub' => 'required|image|max:2048',
            'fiche_pdf' => 'nullable|file|max:2048',
            'lien_youtube' => 'required|string',
            'type_activite' => 'required|string',
            'domaine_activite' => 'required|string',
            'nbr_seances_semaine' => 'required|integer|min:1',
            'tarif' => 'required|numeric|min:0',
            'effectif_min' => 'required|integer|min:0',
            'effectif_max' => 'required|integer|min:0|gte:effectif_min',
            'effectif_actuel' => 'required|integer|lte:effectif_max',
            'age_min' => 'required|integer|min:0',
            'age_max' => 'required|integer|min:0|gte:age_min',
            'option_paiement' => 'required|array',
            'remise' => 'required|array|min:0|max:100',
            'date_debut_etud'=>'required|date',
            'date_fin_etud'=>'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // Store the uploaded image in the specified path
        $imagePath = $request->file('image_pub')->storeAs('public/images', $request->file('image_pub')->getClientOriginalName());
        $imageUrl = Storage::url($imagePath);

        // Store the uploaded PDF (if provided) in the specified path
        $pdfUrl = null;
        if ($request->hasFile('fiche_pdf')) {
            $pdfPath = $request->file('fiche_pdf')->storeAs('public/pdfs', $request->file('fiche_pdf')->getClientOriginalName());
            $pdfUrl = Storage::url($pdfPath);
        }
        
        // Create a new instance of activity with request data
        $activityData = Arr::except($request->all(),['option_paiement', 'remise']);
        $activity = new Activite($activityData);
        // Set image and PDF URLs
        $activity->image_pub = $imageUrl;
        $activity->fiche_pdf = $pdfUrl;
        // Set administrator ID
        $activity->administrateur_id = (Auth::user())->administrateur->id; // Assuming the administrator ID or use any other mechanism to determine it
        
        try {
            // Save the activity to the database
            
            $activity->save();
            $i = 0;
            foreach($request->option_paiement as $option_paiement)
            {
                $activity->paiements()->attach($option_paiement, ['remise' => $request->remise[$i]]);
                $i++;
            }

            // Return success message with the created activity
            return response()->json(['message' => 'Activity created successfully', 'activity' => $activity], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollback();
            // Return error message with exception
            return response()->json(['message' => 'Failed to create activity: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Find the activity by its ID along with its horaires
            $activity = Activite::find($id);
            // If the activity doesn't exist, return a 404 response
            if (!$activity) {
                return response()->json(['message' => 'Activity not found'], 404);
            }
            $horaires = $activity->horaires()->get()->makeHidden(['pivot','created_at','updated_at']);
            $paiements_data = $activity->paiements()->get();
            $paiements = [];
            foreach($paiements_data as $paiement)
            {
                $paiements[] = [
                    "id"=> $paiement->id,
                    "option_paiement"=> $paiement->option_paiement,
                    'remise'=> $paiement->pivot->remise,
                ];
            }
            
            // Return the activity with its horaires as JSON response
            return response()->json([
                'activite'=>$activity,
                'hoaraires'=>$horaires,
                'mode_paiements'=>$paiements
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching activity: ' . $e->getMessage());
            // Return an error response
            return response()->json(['message' => 'An error occurred while fetching activity'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) // sakhri khso ykemla
    {
        // Find the activity by its ID
        $activity = Activite::findOrFail($id);

        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'objectifs' => 'sometimes|string',
            'image_pub' => 'sometimes|image|max:2048',
            'fiche_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'lien_youtube' => 'sometimes|string|url',
            'type_activite' => 'sometimes|string',
            'domaine_activite' => 'sometimes|string',
            'nbr_seances_semaine' => 'sometimes|integer|min:1',
            'tarif' => 'sometimes|numeric|min:0',
            'effectif_min' => 'sometimes|integer|min:0',
            'effectif_max' => 'sometimes|integer|min:0|gte:effectif_min',
            'age_min' => 'sometimes|integer|min:0',
            'age_max' => 'sometimes|integer|min:0|gte:age_min',
        ]);

        dd($request->all());
        // Handle file uploads
        if ($request->hasFile('image_pub')) {
            $validatedData['image_pub'] = $request->file('image_pub')->store('images', 'public');
        }

        if ($request->hasFile('fiche_pdf')) {
            $validatedData['fiche_pdf'] = $request->file('fiche_pdf')->store('pdfs', 'public');
        }

        // Update the activity with the validated data
        $activity->fill($validatedData);
        $activity->save();

        // Return a success message along with the updated activity as JSON response
        return response()->json(['message' => 'Activity updated successfully', 'activity' => $activity]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the activity by its ID
        $activity = Activite::find($id);
        // If the activity doesn't exist, return a 404 response
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        // Delete the activity from the database
        $activity->delete();
        // Return a success message as JSON response
        return response()->json(['message' => 'Activity deleted successfully']);
    }

    /**
     * Display a specific horaire for an activity.
     *
     * @param  int  $activityId
     * @param  int  $horaireId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function showHoraire($activityId, $horaireId)
    // {
    //     // Find the horaire by its ID
    //     $horaire = Horaire::find($horaireId);
    //     // If the horaire doesn't exist, return a 404 response
    //     if (!$horaire) {
    //         return response()->json(['message' => 'Horaire not found'], 404);
    //     }
    //     // Return the horaire as JSON response
    //     return response()->json($horaire);
    // }

    /**
     * List all horaires for a specific activity.
     *
     * @param  int  $activityId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function indexHoraires($activityId)
    // {
    //     // Find the activity by its ID
    //     $activity = Activite::find($activityId);
    //     // If the activity doesn't exist, return a 404 response
    //     if (!$activity) {
    //         return response()->json(['message' => 'Activity not found'], 404);
    //     }

    //     // Retrieve all horaires associated with the activity
    //     $horaires = $activity->horaires()->get();
    //     // Return the horaires as JSON response
    //     return response()->json($horaires);
    // }

    /**
     * Delete a specific horaire from an activity.
     *
     * @param  int  $activityId
     * @param  int  $horaireId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function detachHoraire($activityId, $horaireId)
    // {
    //     // Find the activity by its ID
    //     $activity = Activite::find($activityId);
    //     // If the activity doesn't exist, return a 404 response
    //     if (!$activity) {
    //         return response()->json(['message' => 'Activity not found'], 404);
    //     }

    //     // Find the horaire by its ID
    //     $horaire = Horaire::find($horaireId);
    //     // If the horaire doesn't exist, return a 404 response
    //     if (!$horaire) {
    //         return response()->json(['message' => 'Horaire not found'], 404);
    //     }

    //     // Detach the horaire from the activity
    //     $activity->horaires()->detach($horaireId);
    //     // Return success message as JSON response
    //     return response()->json(['message' => 'Horaire association with the activity removed successfully']);
    // }

    /**
     * Store a new horaire for a specific activity.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $activityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseHoraire(Request $request, $activityId)
    {
        // Find the activity by its ID
        $activity = Activite::find($activityId);
        // If the activity doesn't exist, return a 404 response
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        
        $validatedData = $request->validate([
            'horaire_id' => 'required|integer|exists:horaires,id',  // Ensure the horaire ID exists in the database
        ]);

        // Fetch the existing horaire from the database
        $horaire = Horaire::find($validatedData['horaire_id']);
        // If the horaire doesn't exist, return a 404 response
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }

        // Associate the horaire with the activity
        $activity->horaires()->attach($horaire->id);

        // Return success response with the associated horaire data
        return response()->json([
            'message' => 'Horaire associated successfully with the activity',
            'activity' => $activity->load('horaires'),  // Optionally return the activity with related horaires
        ], 201);
    }


    // ------ CUD sur les Options de paiements + remises ------ //

    public function storeOP(Request $request, $activiteId)
    {
        // validate input....
        $fields= $request->validate([
            'paiement_id' => 'required|integer|exists:paiements,id',  
            'remise' => 'required|numeric|min:0|max:100'
        ]);
        
        if( ! $activite = Activite::find($activiteId))
        {
            return response()->json([
                'message' => 'l\'activite choisie n\'existe pas',
            ], 403);
        }

        if( paiement::find($request->paiement_id))
        {
            // paiement existe
            if ( ! $activite->paiements()->find($fields['paiement_id']) )
            {
                // pas d'occurence
                $activite->paiements()->attach($fields(['paiement_id']),['remise' =>$fields['remise']]);

                return response()->json([
                    'message' => 'le mode de paiment est cree avec succes',
                    'paiements' => $activite->paiements,
                ], 201);
            }
            else
            {
                return response()->json([
                    'message' => 'le nouveau mode de paiment va creer des occurences',
                ], 403);
            }
        }
        else
        {
            return response()->json([
                'message' => 'le mode de paiment choisie n\'existe pas',
            ], 403);
        }

    }
    public function updateOP(Request $request, $activiteId, $paiementId)
    {
        // validate input....
        $fields= $request->validate([
            'paiement_id' => 'required|integer|exists:paiements,id',  
            'remise' => 'required|numeric|min:0|max:100'
        ]);
        
        if( ! $activite = Activite::find($activiteId))
        {
            return response()->json([
                'message' => 'l\'activite choisie n\'existe pas',
            ], 404);
        }
        
        if( paiement::find($paiementId) && paiement::find($request->paiement_id))
        {
            // paiement existe
            if ( ! $activite->paiements()->where('paiement_id','!=',$paiementId)->find($fields['paiement_id']) )
            {
                // pas d'occurence
                $activite->paiements()->updateExistingPivot($paiementId,['paiement_id'=> $fields['$paiementId'], 'remise' =>$fields['remise']]);
                return response()->json([
                    'message' => 'le mode de paiment est mise a jour avec succes',
                    'paiements' => $activite->paiements,
                ], 200);
            }
            else
            {
                return response()->json([
                    'message' => 'le nouveau mode de paiment va creer des occurences',
                ], 409);
            }
        }
        else
        {
            return response()->json([
                'message' => 'le mode de paiment choisie n\'existe pas',
            ], 404);
        }

    }
    public function destroyOP($activiteId, $paiementId)
    {
        if( ! $activite = Activite::find($activiteId))
        {
            return response()->json([
                'message' => 'l\'activite choisie n\'existe pas',
            ], 403);
        }

        if( $activite->paiements()->find($paiementId))
        {
            $activite->paiements()->detach($paiementId);
            return response()->json([
                'message' => 'le mode de paiment est supprimer avec succes',
                'paiements' => $activite->paiements,
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'le mode de paiment a supprimer n\'existe pas',
            ], 403);
        }
        
    }

    
    public function getAvailableActivities()
{
    // Retrieve activities without assigned animators
    $availableActivities = Activite::doesntHave('getAnimateurs')->get();

    // Return available activities as JSON response
    return response()->json(['available_activities' => $availableActivities]);
}

public function assignAnimatorToActivity($activityId, $animatorId)
{
    // Find the activity
    $activity = Activite::findOrFail($activityId);

    // Find the animator
    $animator = animateur::findOrFail($animatorId);
// Get the first horaire ID associated with the activity (You might need to adjust this logic if there's a specific rule to choose the horaire)
$horaireId = $activity->horaires->first()->id;

// Attach the animator to the activity with the horaire_id
$activity->getAnimateurs()->attach($animator->id, ['horaire_id' => $horaireId]);

    return response()->json(['message' => 'Animator assigned to activity successfully', 'activity' => $activity]);
}

// its still needs some work to filter all the horaires ,and domain
public function getAvailableAnimatorsForActivity($activityId)
{
    // Retrieve the activity
    $activity = Activite::findOrFail($activityId);

    $horaireId = $activity->horaires->first()->id;

    // Retrieve available animators for the activity
    $availableAnimators = Animateur::whereDoesntHave('getActivites', function ($query) use ($activityId) {
        $query->where('activite_id', $activityId);
    })->whereHas('horaires', function ($query) use ($horaireId) {
        $query->where('horaires.id', $horaireId);
    })->get();

    // Return available animators as JSON response
    return response()->json(['available_animators' => $availableAnimators]);
}

}

