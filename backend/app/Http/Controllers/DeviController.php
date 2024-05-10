<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\devi;
use App\Models\demande;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeviController extends Controller
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
        {
            $devis = ($user->parentmodel)->devis()->get()->setHidden(['parentmodel_id','updated_at']);
            $data = [
                'devis'=>$devis,
            ];
        }
        else
        {
            // admin
            $deviss = devi::get()->makeHidden(['created_at','updated_at']);
            $data = [];
            foreach($deviss as $devis)
            {
                $parentData = $devis->parentmodel()->first()->makeHidden(['created_at','updated_at','user_id']);
                $userData = $parentData->user()->first()->makeHidden(['created_at','updated_at','role','id']);
                $data[] = [
                    'devis' => $devis,
                    'parent' => array_merge($parentData->toArray(), $userData->toArray()),
                ];
            }
        }

        return $data;

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

    // ------ Methodes appelable dans autre Controller ------ //


    /**
     * Affichage de detail d'un devis associer a une demande et un parent
     * 
     * @param int $parentmodel_id
     * @param int $demande_id
     * @return array
     */
    public static function getDevis(int $parent, int $demande = null) : array
    {
        if($demande)
        $data = devi::where('parentmodel_id', $parent)->where('demande_id',$demande)->first()->makeHidden(['parentmodel_id','demande_id']);
        else
        $data = devi::where('parentmodel_id', $parent)->get()->makeHidden(['parentmodel_id']);

       return $data->toArray();
    }


        /**
     * Calcule de prix d'un devis
     * 
     * @param int $demande_id
     * @param array $enfantActivites
     * @param int $tva
     * @return array
     */
    public static function calculerPrix($demande_id = 1,$enfantActivites = [], $tva = 20) : array
    {
        $demande = demande::find($demande_id);
        $prixHT = 0;

        if($pack = $demande->pack()->first())
        {
            if($pack->id == 1) // Pack Multi-Activités
            {
                $prixRemise = 0;
                $remiseComule = 0;
                foreach ($enfantActivites as $key => $enfantActivite)
                {
                    if($key == 0) // la 1er activite
                        $remise = 0;
                    else
                    {   
                        // augmentation de 5%
                        $remiseComule += 10;
                        // ne depasse pas remise% de remise
                        $remise = min($remiseComule, $pack->remise) / 100;
                    }
                    // cumuler les prix calculer avec remise
                    $prixHT += $enfantActivite['tarif'];
                    $prixRemise += $enfantActivite['tarif'] * (1 - $remise);
                }
                
            }
            if($pack->id == 2) // Pack Familial
            {
                $countEnfants = count($enfantActivites);
                $prixRemise = 0;
                for($i = 0; $i < $countEnfants; $i++)
                {
                    
                    $remise = min($i*10, $pack->remise) / 100;
                    $prixRemise += $enfantActivites[0]['tarif'] * (1 - $remise);
                }
                $prixHT += $enfantActivites[0]['tarif'] * $countEnfants;
            }
            if($pack->id == 3) // Pack nombre d'Activites ( +eurs enfants -> +eurs activites)
            {
                $enfants = $demande->getEnfants()->distinct('id')->get();
                
                $prixRemise = 0;
                
                foreach($enfants as $enfant)
                {
                    $activites = $demande->getActvites()->where('enfant_id',$enfant->id)->orderBy('tarif')->get();
    
                    $remiseComule = 10;
                    foreach ($activites as $key => $activite)
                    {
                        $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                        $tarif = $activite->tarif*(1 - $remise/100);
                        if($key == 0) // la 1er activite de cette enfant
                            $remise = 0;
                        else
                        {   
                            // augmentation de remise%
                            $remiseComule += 10;
                            // ne depasse pas 45% de remise
                            $remise = min($remiseComule, $pack->remise) / 100;
                        }
                        // cumuler les prix calculer avec remise
                        $prixHT += $tarif;
                        $prixRemise += $tarif * (1 - $remise);
                    }
                }
            }
            if($pack->id == 4) // Pack nombre d’enfants ( +eurs enfants -> +eurs activites)
            {
                $activites = $demande->getActvites()->distinct('id')->get();
                
                $prixRemise = 0;
                
                foreach($activites as $activite)
                {
                    $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                    $tarif = $activite->tarif*(1 - $remise/100);

                    $enfants = $demande->getEnfants()->where('activite_id',$activite->id)->get();
    
                    $remiseComule = 10;
                    foreach ($enfants as $key => $enfant)
                    {
    
                        if($key == 0) // la 1er activite de cette enfant
                            $remise = 0;
                        else
                        {   
                            // augmentation de remise%
                            $remiseComule += 10;
                            // ne depasse pas 45% de remise
                            $remise = min($remiseComule, $pack->remise) / 100;
                        }
                        // cumuler les prix calculer avec remise
                        $prixHT += $tarif;
                        $prixRemise += $tarif * (1 - $remise);
                    }
                }
            }

        }
        elseif($offre = $demande->offre()->first())
        {
            foreach($enfantActivites as $enfantActivite)
                $prixHT += $enfantActivite['tarif'];

            $prixRemise = $prixHT*(1 - $offre->remise/100);
        }
        else
        {
            foreach($enfantActivites as $enfantActivite)
                $prixHT += $enfantActivite['tarif'];
            $prixRemise = $prixHT;
        }


        $TTC = $prixRemise*(1 + $tva/100);

            return [
                'HT'=>$prixHT,
                'Remise'=>$prixRemise,
                'TTC'=>$TTC,
            ];
    }

    /**
     * Creation d'une instance de devis pour les Offre
     * 
     * @param int $demande_id
     * @param int $tva
     * @return 
     */
    public static function createDevis($demande_id = 1, $tva = 20)
    {
        $demande = demande::find($demande_id);
        $parent = $demande->parentmodel()->first();
        $offre = $demande->offre()->first();
        $enfants = $demande->getEnfants()->distinct('id')->get();

        $enfantActivites = [];
        foreach($enfants as $enfant)
        {
            // un seul couple [activite - enfant] par demande de type Offre
            $activites = $demande->getActvites()->where('enfant_id',$enfant->id)->orderBy('tarif')->get();
            foreach($activites as $activite){
                $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                $tarif = $activite->tarif*(1 - $remise/100);
                $enfantActivites[] = [
                    'enfant'=>$enfant->prenom,
                    'activite'=>$activite->titre,
                    'effictif'=>$activite->effectif_actuel.' sur '.$activite->effectif_max,
                    'seances'=>$activite->nbr_seances_semaine,
                    'tarif'=>$tarif,
                ];
            }
        }
        // calcule des tarif
        $prix = deviController::calculerPrix($demande_id, $enfantActivites, $tva);
        // Ajout de 14 jours à la date de demande
        $expiration = Carbon::parse($demande->date_demande)->addWeeks(2)->format('Y-m-d');
        
        $data = [
            'serie'=>'D'.Carbon::now()->format('yWw').$parent->id.$demande->id,
            'demande' => $demande,
            'expiration' => $expiration,
            'offre'=> $offre,
            'pack'=>$demande->pack()->first(),
            'parent'=>$parent->user,
            'enfantsActivites'=>$enfantActivites,
            'optionPaiment'=>$demande->paiement()->first()->option_paiement,
            'prixHT'=>$prix['HT'],
            'prixRemise'=>$prix['Remise'],
            'TVA'=> $tva,
            'TTC'=>$prix['TTC'],
        ];


        // creer pdf
        $pdf = Pdf::loadView('pdfs.devisTemplateOffre', $data);

        // Store the pdf in local
        $pdfPath = 'storage/pdfs/devis/'.$data['serie'].'.pdf';
        //$pdf->save($pdfPath);

        return $pdf->download($data['serie'].'.pdf');  // pour le telechargement
        
        //return response()->json($data);



         
    }


}
