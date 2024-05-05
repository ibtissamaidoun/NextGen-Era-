<?php

namespace App\Http\Controllers;

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

        // donnes valides
        if( ! pack::firstWhere('type',$request['type']) ) 
        {
            // nv pack non existant
            pack::create([
                'type'=> $request['type'],
                'description'=>$request['description'],
                'remise'=> $request['remise']
            ]);

            return response()->json([
                'message'=> 'Creation avec succes.',
                'pack'=> pack::firstWhere('type',$request['type'])
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

        //valide data
        if($pack = pack::find($pack_id))
        {
            // pack existe
            if( !pack::where('type',$request['type'])->where('id','!=',$pack_id)->first())
            {
                // la modification du pack ne creer pas de occurence

                $pack->update([
                    'type'=> $request['type'],
                    'description'=>$request['description'],
                    'remise'=> $request['remise']
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
}
