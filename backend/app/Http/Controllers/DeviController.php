<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use App\Models\devi;
use App\Models\offre;

use App\Models\demande;
use App\Models\notification;
use App\Models\parentmodel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

        if ($user && $user->role == 'parent') {
            $devis = ($user->parentmodel)->devis()->get()->setHidden(['parentmodel_id', 'updated_at']);
            $data = [
                'devis' => $devis,
            ];
        } else {
            // admin
            $deviss = devi::get()->makeHidden(['created_at', 'updated_at']);
            $data = [];
            foreach ($deviss as $devis) {
                $parentData = $devis->parentmodel()->first()->makeHidden(['created_at', 'updated_at', 'user_id']);
                $userData = $parentData->user()->first()->makeHidden(['created_at', 'updated_at', 'role', 'id']);
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
        try {
            if ($user && $user->role == 'parent')
                $devis = ($user->parentmodel)->devis()->find($devi)->setHidden(['parentmodel_id']);
            else
                $devis = devi::with('parentmodel')->find($devi);
        } catch (\Throwable $th) {
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
    public function update(Request $request, $devis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($devi)
    {
        $user = Auth::User();
        try {
            if ($user && $user->role == 'parent') {
                $devis = ($user->parentmodel)->devis()->find($devi);
                if (!$devis)
                    return response()->json([
                        'message' => 'Acces non autorisee'
                    ], 403);
            }

            $devis->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Deleted with succes'
        ]);
    }

    // ------ Methodes appelable dans autre Controller ------  //


    /**
     * Affichage de detail d'un devis associer a une demande et un parent
     * 
     * @param int $parentmodel_id
     * @param int $demande_id
     * @return array
     */
    public static function getDevis(int $parent, int $demande = null): array
    {
        if ($demande)
            $data = devi::where('parentmodel_id', $parent)->where('demande_id', $demande)->first()->makeHidden(['parentmodel_id', 'demande_id']);
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
    protected static function calculerPrix($demande_id = 1, $enfantActivites = [], $tva = 20): array
    {
        $demande = demande::find($demande_id);
        $prixHT = 0;

        if ($pack = $demande->pack()->first()) {
            if ($pack->id == 1) // Pack Multi-Activités
            {
                $prixRemise = 0;
                $remiseComule = 0;
                foreach ($enfantActivites as $key => $enfantActivite) {
                    if ($key == 0) // la 1er activite
                        $remise = 0;
                    else {
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
            if ($pack->id == 2) // Pack Familial
            {
                $countEnfants = count($enfantActivites);
                $prixRemise = 0;
                for ($i = 0; $i < $countEnfants; $i++) {

                    $remise = min($i * 10, $pack->remise) / 100;
                    $prixRemise += $enfantActivites[0]['tarif'] * (1 - $remise);
                }
                $prixHT += $enfantActivites[0]['tarif'] * $countEnfants;
            }
            if ($pack->id == 3) // Pack nombre d'Activites ( +eurs enfants -> +eurs activites)
            {
                $enfants = $demande->getEnfants()->distinct('id')->get();

                $prixRemise = 0;

                foreach ($enfants as $enfant) {
                    $activites = $demande->getActvites()->where('enfant_id', $enfant->id)->orderBy('tarif')->get();

                    $remiseComule = 10;
                    foreach ($activites as $key => $activite) {
                        $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                        $tarif = $activite->tarif * (1 - $remise / 100);
                        if ($key == 0) // la 1er activite de cette enfant
                            $remise = 0;
                        else {
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
            if ($pack->id == 4) // Pack nombre d’enfants ( +eurs enfants -> +eurs activites)
            {
                $activites = $demande->getActvites()->distinct('id')->get();

                $prixRemise = 0;

                foreach ($activites as $activite) {
                    $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                    $tarif = $activite->tarif * (1 - $remise / 100);

                    $enfants = $demande->getEnfants()->where('activite_id', $activite->id)->get();

                    $remiseComule = 10;
                    foreach ($enfants as $key => $enfant) {

                        if ($key == 0) // la 1er activite de cette enfant
                            $remise = 0;
                        else {
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
        } elseif ($offre = $demande->offre()->first()) {
            foreach ($enfantActivites as $enfantActivite)
                $prixHT += $enfantActivite['tarif'];

            $prixRemise = $prixHT * (1 - $offre->remise / 100);
        } else {
            foreach ($enfantActivites as $enfantActivite)
                $prixHT += $enfantActivite['tarif'];
            $prixRemise = $prixHT;
        }


        $TTC = $prixRemise * (1 + $tva / 100);

        return [
            'HT' => $prixHT,
            'Remise' => $prixRemise,
            'TTC' => $TTC,
        ];
    }

    /**
     * Creation d'une instance de devis pour les Offre
     * 
     * @param int $demande_id
     * @param int $tva
     * @return 
     */


    protected static function generateDevis($demande_id, $data)
    {
        // loader le Devis en html
        if ($data['offre']) {
            unset($data['pack']);
            $html = view('pdfs.devisTemplateOffre', $data)->render();
        } elseif ($data['pack']) {
            unset($data['offre']);
            $html = view('pdfs.devisTemplatePack', $data)->render();
        } else {
            unset($data['pack']);
            unset($data['offre']);
            $html = view('pdfs.devisTemplate', $data)->render();
        }

        // creer pdf
        $pdf = \App::make('snappy.pdf.wrapper');
        $output = $pdf->loadHTML($html)->output();
        // Store the pdf in local
        $pdfPath = 'storage/pdfs/devis/' . $data['serie'] . date('_His') . '.pdf';
        // enregister localement
        $pdf->save($pdfPath, true);

        // ajout de path de pdf generer
        $data['pdfPath'] = $pdfPath;

        // supprimer l'atribut image de table $data
        unset($data['image']);


        //return response()->download($pdfPath);  // pour le telechargement
        $devis = Devi::create([
            'tarif_ht' => $data['prixHT'],
            'tarif_ttc' => $data['TTC'],
            'tva' => $data['TVA'],
            'devi_pdf' => $data['pdfPath'],
            'parentmodel_id' => $data['parent']->parentmodel->id,
            'demande_id' => $demande_id,
            //'date_expiration'=>$expiration,
        ]);
        $data['devis'] = $devis->id;

        return $data;
    }

    public function chooseofferAndGenerateDevis(Request $request, $offerId)
    {
        try {
            $validated = $request->validate([
                'enfants' => 'required|array',
                'enfants.*' => 'exists:enfants,id'
            ]);

            $childrenIds = $validated['enfants'];

            // Retrieve the offer and all associated activities
            $offer = offre::with('activites')->findOrFail($offerId);
            $allActivities = $offer->activites;

            // Check if the offer has associated payment and retrieve the payment ID
            $payment = $offer->paiement()->first();
            if (!$payment) {
                throw new \Exception("No payment associated with the offer.");
            }
            $paymentId = $payment->id;

            $user = Auth::User();
            $parent = $user->parentmodel;

            // Create a new demande
            $demande = Demande::create([
                'offre_id' => $offerId,
                'paiement_id' => $paymentId,
                'parentmodel_id' => $parent->id,
                'statut' => 'brouillon',
                'date_demande' => now()
            ]);
            //     dd($demande);

            // Fill the pivot table for each child and each activity
            foreach ($childrenIds as $childId) {
                foreach ($allActivities as $activity) {
                    $demande->getActvites()->attach($activity->id, ['enfant_id' => $childId]);
                }
            }
            // the problem i this function create devis
            // Generate a devis for the parent after filling the pivot table
            $data = $this->createDevis($demande->id, 10);
            $devis = Devi::findOrFail($data['devis'])->makeHidden(['created_at', 'updated_at', 'id']);
            return response()->json([
                'message' => 'Devis generated successfully for selected children and all activities in the offer',
                'devis' => $devis
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate devis: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to generate devis: ' . $e->getMessage()], 500);
        }
    }



    protected static function createDevis($demande_id, $tva = 20, $status = true)
    {
        $demande = demande::find($demande_id);
        $parent = $demande->parentmodel()->first();
        $offre = $demande->offre()->first();
        $enfants = $demande->getEnfants()->distinct('id')->get();

        $enfantActivites = [];
        foreach ($enfants as $enfant) {
            // un seul couple [activite - enfant] par demande de type Offre
            $activites = $demande->getActvites()->where('enfant_id', $enfant->id)->orderBy('tarif')->get();
            foreach ($activites as $activite) {
                if ($demande->pack_id)
                    $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                else
                    $remise = 0;

                $tarif = $activite->tarif * (1 - $remise / 100);
                $enfantActivites[] = [
                    'enfant' => $enfant->prenom,
                    'activite' => $activite->titre,
                    'effictif' => $activite->effectif_actuel . ' sur ' . $activite->effectif_max,
                    'seances' => $activite->nbr_seances_semaine,
                    'tarifSans' => $activite->tarif,
                    'tarif' => $tarif,
                    'remise' => $remise,
                ];
            }
        }
        // calcule des tarif
        $prix = deviController::calculerPrix($demande_id, $enfantActivites, $tva);
        // Ajout de 14 jours à la date de demande
        $expiration = Carbon::parse($demande->date_demande)->addWeeks(2)->format('Y-m-d');

        // image de NEXGENERA
        $path = base_path('public\storage\images\OrangeNext@Ai.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $imgData = file_get_contents($path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($imgData);

        $data = [
            'serie' => 'D' . Carbon::now()->format('yWw') . $parent->id . $demande->id,
            'demande' => $demande,
            'expiration' => $expiration,
            'offre' => $offre,
            'pack' => $demande->pack()->first(),
            'parent' => $parent->user()->first(),
            'enfantsActivites' => $enfantActivites,
            'optionPaiment' => $demande->paiement()->first()->option_paiement,
            'prixHT' => $prix['HT'],
            'prixRemise' => $prix['Remise'],
            'TVA' => $tva,
            'TTC' => $prix['TTC'],
            'image' => $img,
        ];
        if ($status) // generer devis si status est true (par default)
            $data = DeviController::generateDevis($demande_id, $data);
        else
            unset($data['image']);

        return $data;
    }
    public function overview($demandeId)
    {
        $data = DeviController::createDevis($demandeId, 20, false);
        if (is_array($data) && isset($data['error'])) {
            // handle error, for example, return it as a response
            return response()->json(['error' => $data['error']], $data['status_code'] ?? 500);
        }
        return response()->json($data);
    }

    public function validatedevis($devisId)
    {
        // Retrieve the devis :)
        $devis = devi::findOrFail($devisId);
        $devis->statut = 'valide';
        $devis->save();

        // Retrieve the  demande :(
        $demande = demande::findOrFail($devis->demande_id);
        $demande->statut = 'en cours';
        $demande->save();

        // Generate a notification for all admins
        $notification = new  notification([
            'type' => 'Devis Validated',
            'contenu' => 'A devis has been validated.'
        ]);
        $notification->save();
        $admins = User::where('role', 'admin')->get();
        $notification->users()->attach($admins);
    }
    public function validatedemande1($demandeid)
    {
        $demande = demande::findOrFail($demandeid);
        $activities = $demande->offre()->first()->activites;

        // Retrieve all children associated with the demande, the power of relations
        $children = $demande->getEnfants();
        $childrenCount = $children->count();

        // Check if adding these children exceeds the maximum capacity for any activity, its smart from my part
        foreach ($activities as $activity) {
            if ($activity->effectif_actuel + $childrenCount > $activity->effectif_max) {
                return response()->json(['error' => 'Validation denied. Maximum capacity reached for one or more activities.'], 422);
            }
        }

        // If capacity is not exceeded, add children to activities and update their schedules in emploi du temps
        foreach ($activities as $activity) {
            $activity->effectif_actuel += $childrenCount;
            $activity->save();
            foreach ($children as $child) {
                $child->activites()->attach($activity->id);
                
                $horaires = $activity->horaires()->get();
                $Data = [
                    'horaire_1' => $horaires[0]->heure_debut ?? null,
                    'horaire_2' => $horaires[1]->heure_debut ?? null
                ];
                $child->activites()->updateExistingPivot($activity->id, $Data);
            }
        }
        // Update the status of the demande :) i am happy if it reaches this
        $demande->statut = 'paye';
        $demande->save();
        //horaires affect the activities horairfes to the emploi du temps

        return response()->json(['message' => 'Demande validated and children placed in activities successfully.']);
    }
}

