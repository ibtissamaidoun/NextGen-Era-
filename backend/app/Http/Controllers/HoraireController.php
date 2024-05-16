<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HoraireController extends Controller
{
    /**
     * Display a listing of horaires.
     */
    public function index()
    {
        $horaires = Horaire::all();
        return response()->json($horaires);
    }

    /**
     * Store a newly created horaire in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'jour_semaine' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        ])->validate();

        $horaire = Horaire::create($validated);

        return response()->json([
            'message' => 'Horaire created successfully',
            'horaire' => $horaire
        ], 201);
    }

    /**
     * Display the specified horaire.
     */
    public function show($id)
    {
        $horaire = Horaire::find($id);
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }

        return response()->json($horaire);
    }

    /**
     * Update the specified horaire in storage.
     */
    public function update(Request $request, $id)
    {
        $horaire = Horaire::find($id);
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }

        $validated = $request->validate([
            'jour_semaine' => 'sometimes|required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'heure_debut' => 'sometimes|required|date_format:H:i',
            'heure_fin' => 'sometimes|required|date_format:H:i|after:heure_debut',
        ]);

        $horaire->update($validated);

        return response()->json([
            'message' => 'Horaire updated successfully',
            'horaire' => $horaire
        ]);
    }

    /**
     * Remove the specified horaire from storage.
     */
    public function destroy($id)
    {
        $horaire = Horaire::find($id);
        if (!$horaire) {
            return response()->json(['message' => 'Horaire not found'], 404);
        }

        $horaire->delete();

        return response()->json(['message' => 'Horaire deleted successfully']);
    }
}