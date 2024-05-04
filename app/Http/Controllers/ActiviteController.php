<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActiviteController extends Controller
{
    /**
     * Affcher la liste des Activites.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all activities
        $activities = Activite::all();
        
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
            'age_min' => 'required|integer|min:0',
            'age_max' => 'required|integer|min:0|gte:age_min',
            'option_paiement' => 'required|string'
        ]);

        // If validation fails, return a response with validation errors
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
        $activity = new Activite($request->all()); // ajout d'option de paiment + 
        // Set image and PDF URLs
        $activity->image_pub = $imageUrl;
        $activity->fiche_pdf = $pdfUrl;
        // Set administrator ID
        $activity->administrateur_id = 1; // Assuming the administrator ID or use any other mechanism to determine it
        
        // Begin database transaction
        DB::beginTransaction();
        try {
            // Save the activity to the database
            $activity->save();

            // Commit the transaction
            DB::commit();

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
            $activity = Activite::with('horaires')->find($id);
            // If the activity doesn't exist, return a 404 response
            if (!$activity) {
                return response()->json(['message' => 'Activity not found'], 404);
            }
            // Return the activity with its horaires as JSON response
            return response()->json($activity);
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
    public function update(Request $request, $id)
    {
        // Find the activity by its ID
        $activity = Activite::findOrFail($id);
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            // Validation rules for activity fields
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'objectifs' => 'sometimes|required|string',
            'image_pub' => 'sometimes|required|image|max:2048',
            'fiche_pdf' => 'nullable|sometimes|file|max:2048',
            'lien_youtube' => 'sometimes|required|string',
            'type_activite' => 'sometimes|required|string',
            'domaine_activite' => 'sometimes|required|string',
            'nbr_seances_semaine' => 'sometimes|required|integer|min:1',
            'tarif' => 'sometimes|required|numeric|min:0',
            'effectif_min' => 'sometimes|required|integer|min:0',
            'effectif_max' => 'sometimes|required|integer|min:0|gte:effectif_min',
            'age_min' => 'sometimes|required|integer|min:0',
            'age_max' => 'sometimes|required|integer|min:0|gte:age_min',
        ]);    
    
        // Update the activity with the validated data
        $activity->update($validatedData);
    
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
    public function showHoraire($activityId, $horaireId)
    {
        // Find the horaire by its ID
        $horaire = Horaire::find($horaireId);
        // If the horaire doesn't exist, return a 404 response
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }
        // Return the horaire as JSON response
        return response()->json($horaire);
    }

    /**
     * List all horaires for a specific activity.
     *
     * @param  int  $activityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexHoraires($activityId)
    {
        // Find the activity by its ID
        $activity = Activite::find($activityId);
        // If the activity doesn't exist, return a 404 response
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        // Retrieve all horaires associated with the activity
        $horaires = $activity->horaires()->get();
        // Return the horaires as JSON response
        return response()->json($horaires);
    }

    /**
     * Delete a specific horaire from an activity.
     *
     * @param  int  $activityId
     * @param  int  $horaireId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachHoraire($activityId, $horaireId)
    {
        // Find the activity by its ID
        $activity = Activite::find($activityId);
        // If the activity doesn't exist, return a 404 response
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        // Find the horaire by its ID
        $horaire = Horaire::find($horaireId);
        // If the horaire doesn't exist, return a 404 response
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }

        // Detach the horaire from the activity
        $activity->horaires()->detach($horaireId);
        // Return success message as JSON response
        return response()->json(['message' => 'Horaire association with the activity removed successfully']);
    }

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

        // Validate the incoming request data to ensure the horaire ID is provided and valid
        $validatedData = $request->validate([
            'horaire_id' => 'required|exists:horaires,id',  // Ensure the horaire ID exists in the database
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
}
