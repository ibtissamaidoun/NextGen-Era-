<?php

namespace App\Http\Controllers;

use App\Models\devi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class deviController extends Controller
{
    /**
     * Afficher tout les devis.
     * 
     * Pour le Parent & Admin
     */
    public function index() 
    {
        $user = Auth::User();

        if($user && $user->role == 'parent')
            $devis = ($user->parentmodel)->devis()->get()->setHidden(['parentmodel_id','updated_at']);
        else
            $devis = devi::with('parentmodel')->get();

        return response()->json($devis);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($demande)
    {
        $parent = (Auth::User())->parentmodel;

        // verifier input...

        // debut

    }

    /**
     * Display the specified resource.
     */
    public function show($devi)
    {
        $user = Auth::User();
        try{
            if($user && $user->role == 'parent')
                $devis = ($user->parentmodel)->devis()->find($devi)->setHidden(['parentmodel_id']);
            else
                $devis = devi::with('parentmodel')->find($devi);
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
                'message' => 'Acces non autorisee'
            ], 403);
        }

        return response()->json($devis);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$devis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($devi)
    {
        $user = Auth::User();
        try{
            if($user && $user->role == 'parent'){
                $devis = ($user->parentmodel)->devis()->find($devi);
                if(!$devis)
                    return response()->json([
                        'message' => 'Acces non autorisee'
                    ], 403);
            }
            
            $devis->delete();
            
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Deleted with succes'
        ]);
    }
}
