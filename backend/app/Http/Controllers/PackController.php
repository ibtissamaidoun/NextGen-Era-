<?php

namespace App\Http\Controllers;

use App\Models\demande;
use App\Models\pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(pack::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation input ....
        $fields=$request->validate([
            'type'=> 'required|string',
            'description'=> 'required|string',
            'remise'=> 'required|integer|min:0|max:100',
        ]);

        // donnes valides
        if( ! pack::firstWhere('type',$fields['type']) ) 
        {
            // nv pack non existant
            pack::create([
                'type'=> $fields['type'],
                'description'=>$fields['description'],
                'remise'=> $fields['remise']
            ]);

            return response()->json([
                'message'=> 'Creation avec succes.',
                'pack'=> pack::firstWhere('type',$fields['type'])
            ]);
        }
        else{
            return response()->json([
                'message'=> 'Pack de type deja existant. (tenter a modifier de type)'
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($pack_id, Request $request)
    {
        // validate input ...
        $fields= $request->validate([
            'type' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'remise' => 'sometimes|required|integer|min:0|max:100',
        ]);
        //valide data
        if($pack = pack::find($pack_id))
        {
            // pack existe
            if( !pack::where('type',$fields['type'])->where('id','!=',$pack_id)->first())
            {
                // la modification du pack ne creer pas de occurence

                $pack->update([
                    'type'=> $fields['type'],
                    'description'=>$fields['description'],
                    'remise'=> $fields['remise']
                ]);
    
                return response()->json([
                    'message'=> 'modification avec succes.',
                    'pack'=> $pack
                ]);
            }
            else{
                return response()->json([
                    'message'=> 'la modification du pack va creer de occurence'
                ]);
            }
        }
        else{
            return response()->json([
                'message'=> 'pack non existant.'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pack_id)
    {
        if( $pack = pack::find($pack_id))
        {
            $pack->delete();

            return response()->json([
                'message'=> 'pack supprimee avec succes'
            ]);
        }
        else
        {
            return response()->json([
                'message'=> 'pack non existant'
            ]);
        }
    }


    // -------- Fonctions appelables ------- //
    /**
     * identification des packs poussibles en se basent sur la demande
     */
    public static function packPoussible($demande_id)
    {
        $demande = demande::find($demande_id);
        $countActivites = $demande->getActvites()->distinct('id')->count();
        $countEnfants = $demande->getEnfants()->distinct('id')->count();

        if($countActivites == 1 && $countEnfants == 1)
        {
            // Pack Basique ( 1 enfant -> 1 activite )
            return 1;
        }
        elseif($countActivites > 1 && $countEnfants == 1)
        {
            // Pack Multi-Activités ( 1 enfant -> +eurs activites )
            return [1, 2];
        }
        elseif($countEnfants > 1 && $countActivites == 1)
        {
            // Pack Familial ( +eurs enfants -> 1 activite )
            return [1, 3];
        }
        else
        {
            // 4- Pack Activites ( +eurs enfants -> +eurs activites)
            // 5- Pack nombre d’enfants ( +eurs enfants -> +eurs activites)
            return [1, 4, 5];
        }

    }
}