<?php

namespace App\Http\Controllers;

use App\Models\demande;
use Illuminate\Http\Request;
use App\Models\parentmodel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(demande $demande)
    {
        //
    }

    //taha partie 
     public function demandes(Request $request)
    {
        try {
            // Retrieve the authenticated parent's ID from the parentmodels table
            $user = $request->user();
            $parent = parentmodel::where('user_id', $user->id)->firstOrFail();
    
            // Retrieve all demandes associated with the parent
            $demandes = $parent->demandes()->get();
    
            // Return the demandes along with their associated children IDs
            return response()->json(['demandes' => $demandes], 200);
        } catch (ModelNotFoundException $e) {
            // Log the specific exception
            logger()->error('Error occurred while fetching demandes: ' . $e->getMessage());
    
            // Return a response indicating parent not found
            return response()->json(['message' => 'Parent not found'], 404);
        } catch (\Exception $e) {
            // Log any other exceptions
            logger()->error('Error occurred while fetching demandes: ' . $e->getMessage());
    
            // Return an error response
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }
}
