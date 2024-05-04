<?php

namespace App\Http\Controllers;

use App\Models\paiement;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as json;

class paiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): json
    {
        return response()->json(paiement::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HttpFoundationRequest $symfonyRequest)
    {
        // ----- REGLAGE DE PROBLEME DE REQUEST VIDE AVEC 'HttpFoundationRequest' ----- //
        $request = new Request( $symfonyRequest->toArray() );
        // ------------- fin solution.
        
        // Validation des entrées
        


        // Si les données sont validées et que l'option de paiement est unique
        if (!Paiement::firstWhere('option_paiement', $request['option_paiement'])) {
            // Création du nouveau mode de paiement
            $paiement = Paiement::create([
                'option_paiement' => $request['option_paiement'],
                'remise' => $request['remise']
            ]);

            return response()->json([
                'message' => 'Création avec succès.',
                'paiement' => $paiement
            ]);
        } else {
            // Si le mode de paiement existe déjà
            return response()->json([
                'message' => 'Mode de paiement déjà existant. Tentez de modifier le type.'
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $paiement_id)
    {
        // valider request ...

        // data validee
        if( $paiement = paiement::find($paiement_id) )
        {
            // mode trouvee
            if(! Paiement::where('option_paiement',$request->option_paiement)->where('id','!=',$paiement_id)->first() ){
                // la modification de mode du paiement ne creer pas de occurence
                $paiement->update([
                    'option_paiement'=> $request['option_paiement'],
                    'remise'=> $request['remise']
                ]);

                return response()->json([
                    'message'=> 'modification avec succes.',
                    'pack'=> $paiement
                ]);
            }
            else{
                return response()->json([
                    'message'=> 'la modification de mode du paiement va creer de occurence'
                ]);
            }
        }
        else{
            return response()->json([
                'message'=> ' mode du paiement non existant.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($paiement_id)
    {
        if( $paiement = paiement::find($paiement_id))
        {
            $paiement->delete();

            return response()->json([
                'message'=> 'mode de paiement supprimee avec succes.'
            ]);
        }
        else{
            return response()->json([
                'message'=> 'mode de paiement non existant'
            ]);
        }
    }
}
