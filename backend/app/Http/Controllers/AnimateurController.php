<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\activite;
use App\Models\animateur;
use App\Models\horaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimateurController extends Controller
{
   
   // -----------------   PARTIE DE CRUD HORAIRES   ----------------- //
    /**
     * Display a listing of heures affectees
     */
    public function indexHeures()
    {
        //debut
        
        $user = Auth::User();
        $animateur = $user->animateur; // $animateur = Auth::user()

       
        if( $animateur->horaires()->exists() )
        {
            $horaires = $animateur->horaires()->get()->makeHidden(['pivot','created_at','updated_at']);
            return response()->json( $horaires );
        }
        else
        return response()->json([ 'message'=>'Pas d\'heures affectees !!!' ], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function storeHeure(Request $request) 
{
    try {
        // Validation des données de la requête
        $fields = $request->validate([
            'horaires' => 'required|array',
            'horaires.*' => 'integer|exists:horaires,id' 
        ]);

        $user = Auth::User();
        $animateur = $user->animateur;

        // Nouvelle logique pour la validation
        if (count($fields['horaires']) > 5) {
            throw new Exception("Vous ne pouvez pas ajouter plus de 5 horaires à la fois.");
        }

        // Logique d'ajout d'horaires
        foreach($fields['horaires'] as $horaireId) {
            $animateur->horaires()->attach($horaireId);
        }

        // Retourner une réponse de succès
        return response()->json([
            'message'=>'Insertion réussie !'
        ], 201);
    }
    catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}

    

    /**
     * Display the specified heure ------ pas utile ------
     */
    public function showHeure($horaire)
    {
    
        return response()->json(
            [
                'horaires'=> horaire::all(),
            ]);
        

        
    }

    /**
     * Modifier une heure deja forni
     */
    public function updateHeure($horaire, Request $request) // id horaire, {horaire:string}
    {
        // validation d'inputs : l'horaire forni est une heure
        $fields = $request->validate([
            'horaires' => 'required|integer|exists:horaires,id' 
        ]);
        // modification d'une instance de 'horaires_disponibilite_animateur'
        $user = Auth::User();
        $animateur_id = ($user->animateur)->id;
        $animateur = animateur::find($animateur_id); // $animateur = Auth::user()


        if( $animateur->horaires()->where('horaire_id',$horaire)->exists() && 
            ! $animateur->horaires()->where('horaire_id',$request->horaire)->exists())

            $animateur->horaires()->updateExistingPivot($horaire,['horaire_id'=>$request->horaire]);
        else
        return response()->json(
            [ 'message'=>'Essaye du mise a jour d\'une heure non existant ou deja existant !' ]
        );
        
        return response()->json(
            [ 'message'=>'Succes du mise a jour de l\'heure.' ]
        );
    }

    /**
     * supprimer une heure affecter
     */
    public function destroyHeure($horaire)
    {
        // validation d'inputs : l'horaire forni est une heure.

        //debut
        $user = Auth::User();
        $animateur_id = ($user->animateur)->id;
        $animateur = animateur::find($animateur_id); // $animateur = Auth::user()

        
        // test si l'heure a supprimer existante ou non
        if( $animateur->horaires()->where('horaire_id',$horaire)->exists())
            $animateur->horaires()->detach($horaire);
        else
        return response()->json(
            [
                'message'=>'Trying to delete unexisting l\'heure !!!'
            ]
        );

        return response()->json(
            [
                'message'=>'Succes du supprision de l\'heure.'
            ]
        );
    }



     // -----------------   PARTIE D'EDT   ----------------- //

     /**
      * Afficher les donners de EDT( couple[activite; heure] )
      */
    public function getEDT()
    {
        // check the curent user
        // Attempt to retrieve the animateur with related activites and horaires eagerly loaded
    $user = Auth::User();
    $animateur_id = ($user->animateur)->id;
    $animateur = Animateur::with(['getActivites','getHoraires'])->findOrFail($animateur_id);
    // with findOrFail the case of NULL is handeled
    // with find the case of NULL is not handeled and may cause problems

    $edt = array();
    // Loop through each activite and associated horaires
    
    foreach ($animateur->getActivites as $activite) 
    {
        foreach ($animateur->getHoraires as $horaire) 
        {
            if($activite->pivot->horaire_id == $horaire->id)
            {
                $edt[] = [
                    'titre' => $activite->titre,
                    'domaine' => $activite->domaine_activite,
                    'type' => $activite->type_activite,
                    'jour' => $horaire->jour_semaine,
                    'heureDebut' => $horaire->heure_debut,
                    'heureFin' => $horaire->heure_fin
                ];
            }
        }
    }

    // Return the data as a JSON response
    return response()->json([
        'data' => $edt
    ]);
    }


    // -----------------   PARTIE D'ACTIVITES   ----------------- //

    /**
     * Afficher les activites d'un animateur
     */
    public function indexActivite()
    {
        //Request $request
        $user = Auth::User();
        $animateur_id = ($user->animateur)->id;
        $animateur = Animateur::with('getActivites')->findOrFail($animateur_id);

        $collection = [];
        $data = [];
        // collection des activites
        foreach( $animateur->getActivites as $activite)
        {
            if( !array_key_exists($activite->id, $collection)){

                $collection[$activite->id] = true;

                $data[] = [
                    'id'=>$activite->id,
                    'titre'=>$activite->titre,
                    'image_pub'=>$activite->image_pub,
                    'type_activite'=>$activite->type_activite,
                    'domaine_activite'=>$activite->domaine_activite
                ];
            }
        }
        // feltring the array
        
    // Return the data as a JSON response
    return response()->json([
        'data' => $data
    ]);
    }

    /**
     * Afficher le detail d'une activite
     */
    public function showActivite($id)
    {
        $user = Auth::User();
        $animateur_id = ($user->animateur)->id;
        $animateur = Animateur::with('getActivites')->findOrFail($animateur_id);

        // search for the specified activite 
        foreach ($animateur->getActivites as $act)
        {
            if( $act->id == $id)
            {
                return response()->json([
                    // get the activite + the students + les horaires
                    'activite'=> $act,
                    'enfants' => $act->enfants()->get(),
                    'horaires'=> $act->getHoraires()->where('animateur_id',$animateur->id)->get()
                ]);
            }
        }
        return response()->json([
            'message' => 'Activite non existant | Access refuser'
        ]);
    }

    /**
     * Aficher un enfant particulier de l'activite choisie
     */
    public function showEtudiant($activite, $etudiant)
    {
        $user = Auth::User();
        $animateur_id = ($user->animateur)->id;
        $animateur = Animateur::with('getActivites')->findOrFail($animateur_id);


        foreach ($animateur->getActivites as $act)
        {
            if( $act->id == $activite)
            {
                $enfant = $act->enfants()->findOrFail($etudiant)->makeHidden('pivot');
                
                return response()->json([
                    // get the student
                    'enfant' => $enfant,
                    'parant' => [
                        'nom' =>($enfant->parentmodel()->first())->user()->first()->nom, 
                        'prenom'=>($enfant->parentmodel()->first())->user()->first()->prenom,
                        'fonction'=>$enfant->parentmodel()->first()->fonction
                        ]
                ]);
            }
        }
        return response()->json([
            'message' => 'Etudiant non existant | Access refuser'
        ]);
    }
}
