<?php

namespace App\Http\Controllers;

use App\Models\enfant;
use App\Models\parentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EnfantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::User();
        if($user && $user->role == 'parent')
        {
            $parent = $user->parentmodel;
            $enfants= $parent->enfants()->get();
        }
        else //si user est un admin il peut voir tout les enfants
            $enfants = Enfant::all();

        return response()->json(['enfants'=>$enfants]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            try{
            // validate the input ....
            $fields = $request->validate(
                [
                    'nom'=> 'required|string',
                    'prenom'=> 'required|string',
                    'date_de_naissance' => [
                        'required',
                        'date',
                        'before:' . now()->subYears(6)->toDateString(), //enfant a au moin 6 ans
                        'after:' . now()->subYears(17)->toDateString(), //enfant a au plus 17 ans
                    ],
                    'niveau_etude' => 'required|in:Primaire,College,Lycee',
                ]
                );


            $user = Auth::User();
            $parent = $user->parentmodel;

            if( ! enfant::where('nom',$request['nom'])
                        ->where('prenom',$request['prenom'])
                        ->where('parentmodel_id',$parent->id)
                        ->first())
            {

                Enfant::create([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_de_naissance' => $request->date_de_naissance,
                    'niveau_etude' => $request->niveau_etude,
                    'parentmodel_id'=>$parent->id,
                ]);

                return response()->json([
                    'message' => 'Enfant créé avec succès',
                    'enfants'=> $parent->enfants,
                ]);
            }

            return response()->json([
                'message'=> 'Un enfant avec ces informations existe déjà'
            ],422);
        }catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

}


    /**
     * Display the specified resource.
     */
    public function show($enfant_id)
    {
        $user = Auth::User();

        if($user && $user->role == 'parent')
        {
            $parent = $user->parentmodel;
            if(! $data = $parent->enfants()->find($enfant_id))
                return response()->json([ 'message'=> 'Un enfant non existant'], 403);

            $data = $data->makeHidden(['created_at','updated_at','parentmodel_id']);
        }
        else
        {
            // admin
            $enfantData = enfant::find($enfant_id)->makeHidden(['created_at','updated_at','parentmodel_id']);
            $parentData = $enfantData->parentmodel()->first()->makeHidden(['created_at','updated_at','user_id']);
            $userData = $parentData->user()->first()->makeHidden(['created_at','updated_at','role','id']);

            $data = [
                'enfant' => $enfantData,
                'parent' => array_merge($parentData->toArray(), $userData->toArray())
            ];

        }

        return response()->json($data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $enfant_id)
    {
        try{
        // validate input ...
        $fields=$request->validate(
            [
                'nom' => 'sometimes|string|max:255',
                'prenom' => 'sometimes|string|max:255',
                'date_de_naissance' => [
                    'sometimes',
                    'date',
                    'before:' . now()->subYears(6)->toDateString(),
                    'after:' . now()->subYears(17)->toDateString(),
                ],
                'niveau_etude' => 'sometimes|in:Primaire,College,Lycee',
            ]
            );

        //valide data
        $user = Auth::User();
        $parent = $user->parentmodel;

        if($enfant = enfant::where('parentmodel_id',$parent->id)->find($enfant_id))
        {
            // enfant existe
            if( !enfant::where('nom',$request['nom'])
                        ->where('prenom',$request['prenom'])
                        ->where('parentmodel_id',$parent->id)
                        ->where('id','!=',$enfant_id)
                        ->first())
            {
                // la modification du enfant ne creer pas de occurence

                $enfant->update([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_de_naissance' => $request->date_de_naissance,
                    'niveau_etude' => $request->niveau_etude
                ]);

                return response()->json([
                    'message'=> 'modification avec succes.',
                    'enfant'=> $enfant
                ]);
            }
            else{
                return response()->json([
                    'message'=> 'la modification du enfant va creer de occurence'
                ],422);
            }
        }
        else{
            return response()->json([
                'message'=> 'enfant non existant.'
            ], 403);
        }
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($enfant_id)
    {
        $user = Auth::User();
        $parent = $user->parentmodel;

        if( $enfant = $parent->enfants()->find($enfant_id) )
        {
            $enfant->delete();

            return response()->json([
                'message'=> 'enfant supprimee avec succes',
                'enfants'=> $parent->enfants,
            ],);
        }
        else
        {
            return response()->json([
                'message'=> 'enfant non existant'
            ], 403);
        }
    }
}
