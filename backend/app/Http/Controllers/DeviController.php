<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\Models\devi;
use App\Models\User;
use App\Models\offre;

use App\Models\enfant;
use App\Models\demande;
use App\Models\facture;

use App\Models\activite;
use App\Models\parentmodel;
use App\Models\notification;
use Illuminate\Http\Request;

use App\Models\administrateur;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 *  !!!!! BE CAREFUL WITH THIS CODE IT'S THE MAIN BRAIN OF ALL THE PROJECT LOGIC, IF IT GOES WE GOES !!!!!
 *
 * AT FIRST ONLY WE AND GOD KNOWS HOW IT WORKS , NOW ONLY GOD KNOWS.
 */

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

    // ------ Methodes appelable dans autre Controller ------ //

    /**
     * Affichage de detail d'un devis associer a une demande et un parent
     * for the admin and the parent it self
     *
     * @param int $parentmodel_id
     * @param int $demande_id
     * @return array
     */
    public static function getDevis(int $parent = 1, int $demande = null): array
    {
        if ($demande)
            $data = devi::where('parentmodel_id', $parent)->where('demande_id', $demande)->first()->makeHidden(['parentmodel_id']);
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
    protected static function calculerPrix($demande_id, $enfantActivites = [], $tva = 20): array
    {
        $demande = demande::find($demande_id);
        $prixHT = 0;

        /**
         * SI ON A UN PACK CHOISIE EN ENTRE DANS LES CAS DES PACKS
         */
        if ($pack = $demande->pack()->first()) {
            switch ($pack->id) {
                    // pack basique
                case 1:
                    foreach ($enfantActivites as $enfantActivite)
                        $prixHT += $enfantActivite['tarif'];
                    $prixRemise = $prixHT;
                    break;
                    // Pack Multi-Activités
                case 2:
                    $prixRemise = 0;
                    $remiseComule = 0;
                    foreach ($enfantActivites as $key => $enfantActivite) {
                        $prixHT += $enfantActivite['tarif'];
                        // LA 1ER ACTIVITÉE
                        if ($key == 0)
                            $remise = 0;
                        else {
                            // AUGMENTATION DE 10%
                            $remiseComule += 10;
                            // NE DEPASSÉE REMISE% DE REMISE
                            $remise = min($remiseComule, $pack->remise) / 100;
                        }
                        // cumuler les prix calculer avec remise

                        $prixRemise += $enfantActivite['tarif'] * (1 - $remise);
                    }
                    break;
                    // Pack Familial
                case 3:
                    $countEnfants = count($enfantActivites);
                    $prixRemise = 0;
                    for ($i = 0; $i < $countEnfants; $i++) {

                        $remise = min($i * 10, $pack->remise) / 100;
                        $prixRemise += $enfantActivites[0]['tarif'] * (1 - $remise);
                    }
                    $prixHT += $enfantActivites[0]['tarif'] * $countEnfants;
                    break;

                    // Pack nombre d'Activites ( +eurs enfants -> +eurs activites)
                case 4:
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
                    break;
                    // Pack nombre d’enfants ( +eurs enfants -> +eurs activites)
                case 5:
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
                    break;
            }
        } elseif ($offre = $demande->offre()->first()) {
            foreach ($enfantActivites as $enfantActivite)
                $prixHT += $enfantActivite['tarif'];

            $prixRemise = $prixHT * (1 - $offre->remise / 100);
        }

        $TTC = $prixRemise * (1 + $tva / 100);

        return [
            'HT' => $prixHT,
            'Remise' => $prixRemise,
            'TTC' => $TTC,
        ];
    }

    /**
     * Collection de DATA pour le Devis
     * Creation d'une instance de (Devis, Facture) pour les Offre et les Activites si statue=true,
     * sinon il calcule la data des devis et des factures sans creer une instance.
     *
     * @param int $demande_id
     * @param string $type
     * @param bool $status
     * @param int $tva
     * @return
     */
    public static function createDevis($demande_id, $type = 'Devis', $status = true, $tva = 20) // on work
    {
        $demande = demande::find($demande_id);
        $parent = $demande->parentmodel()->first();
        $offre = $demande->offre()->first();
        $pack = $demande->pack()->first();
        $enfants = $demande->getEnfants()->distinct('id')->get();

        $enfantActivites = [];
        foreach ($enfants as $enfant) {
            /**
             * TOUTE LES ACTIVITÉ DE CETTE ENFANT
             */
            $activites = $demande->getActvites()->where('enfant_id', $enfant->id)->orderBy('tarif')->get();

            foreach ($activites as $activite) {
                /**
                 * REMISE D'OPTION DE PAIEMENT POUR ACTIVITÉE
                 */
                if ($demande->pack_id)
                    $remise = $activite->paiements()->find($demande->paiement()->first()->id)->pivot->remise;
                else
                    $remise = 0;

                $tarif = $activite->tarif * (1 - $remise / 100);

                /**
                 * COUPLE ACTIVITÉ - ENFANT
                 */
                $enfantActivites[] = [
                    'enfant' => $enfant->prenom,
                    'enfantData' => $enfant,
                    'activite' => $activite->titre,
                    'activiteData' => $activite,
                    'effictif' => $activite->effectif_actuel . ' sur ' . $activite->effectif_max,
                    'seances' => $activite->nbr_seances_semaine,
                    'tarifSans' => $activite->tarif,
                    'tarif' => $tarif,
                    'remise' => $remise,
                ];
            }
        }

        /**
         * CALCULE DE TOUT LES PRIX
         */
        $prix = deviController::calculerPrix($demande_id, $enfantActivites, $tva);

        /**
         * IMAGE DE SITE : NEXGENERA
         */
        $path = base_path('public\storage\images\OrangeNext@Ai.jpg');
        $typeImg = pathinfo($path, PATHINFO_EXTENSION);
        $imgData = file_get_contents($path);
        $img = 'data:image/' . $typeImg . ';base64,' . base64_encode($imgData);

        /**
         * AFFICHAGE DE PRIX PAR RAPPORT À L'OPTION DE PAIEMENT
         */
        if ($offre) {
            $start = Carbon::parse($offre->date_debut);
            $end = Carbon::parse($offre->date_fin);
        } elseif ($pack) {
            $start = Carbon::parse($activites[0]->date_debut_etud);
            $end = Carbon::parse($activites[0]->date_fin_etud);
        }
        /**
         * PREPARATION DE L'AFFICHAGE DES PRIX PAR O.P.
         */
        switch ($demande->paiement()->first()->option_paiement) {
            case 'mensuel':
                $period = $start->diffInMonths($end);
                $traite = $prix['TTC'] / $period;
                $prixOP = $traite . ' DH / mois';
                $periodMsg = $period . ' mois';
                break;
            case 'trimestriel':
                $period = $start->diffInMonths($end) / 3;
                $traite = $prix['TTC'] / $period;
                $prixOP = $traite . ' DH / trimestre';
                $periodMsg = $period . ' trimestres';
                break;
            case 'semestriel':
                $period = $start->diffInMonths($end) / 6;
                $traite = $prix['TTC'] / $period;
                $prixOP = $traite . ' DH / semestre';
                $periodMsg = $period . ' semestres';
                break;
            case 'annuel':
                $period = $start->diffInYears($end);
                $traite = $prix['TTC'] / $period;
                $prixOP = $traite . ' DH / annee';
                $periodMsg = $period . ' annees';
                break;
        }

        /**
         * CALCULE DE DATE D'ÉXPIRATION DE DEVIS APRES 24 HEURES +1 FOR AJUSTMENT
         */
        $expiration = Carbon::parse($demande->date_demande . ' ' . date('H:i'))->addHours(25)->format('Y-m-d H:i');

        //dd($expiration);
        /**
         * LA DATA POUR GÉNÉRER LE PDF POUR LE DEVIS ET LA FACTURE
         */
        $data = [
            'serie' => 'D' . Carbon::now()->format('yWw') . $parent->id . $demande->id,
            'demande' => $demande,
            'expiration' => $expiration,
            'offre' => $offre,
            'pack' => $pack,
            'parent' => $parent->user()->first(),
            'enfantsActivites' => $enfantActivites,
            'optionPaiment' => $demande->paiement()->first()->option_paiement,
            'prixHT' => $prix['HT'],
            'prixRemise' => $prix['Remise'],
            'TVA' => $tva,
            'TTC' => $prix['TTC'],
            'image' => $img,
            'type' => $type,
            'prixOP' => $prixOP,
            'period' => $periodMsg,
            'nbrTraite' => $period,
            'tarif_traite' => $traite,
        ];

        /**
         * CODE DE GENERATION DE PDF SI STATUT = TRUE, SINON JUST RETOURNE LA DATA
         */
        if ($status) {
            if (strtoupper($type) == 'DEVIS') {
                $data = DeviController::generateDevis($demande_id, $data);
            } elseif (strtoupper($type) == 'FACTURE') {
                $devis = $demande->devi;
                $data['devis_id'] = $devis->id;
                $data['serie'] = 'F' . Carbon::now()->format('yWw') . $parent->id . $demande->id;
                /** EXPIRATION DE FACTURE APRES 15 JOURES */
                $data['expiration'] = Carbon::parse($demande->updated_at)->addDays(15)->format('Y-m-d H:i');
                $data = DeviController::generateDevis($demande_id, $data, 'facture');
                unset($data['devis_id']);
            }
        }

        return $data;
    }
    /**
     *  -- apres action de anass
     *  ->>>  TODO : 1- // annuler // Need to planifier les factures et automatiser l'envoie des facture
     *               2- generation des recu apres payement des facture (is_paye = true)
     * */

    protected static function generateDevis($demande_id, $data, $type = 'Devis')
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
        $pdf = App::make('snappy.pdf.wrapper'); // !!!!! DON'T CHANGE THIS LINE, IT WORKS PERFECTLY FINE !!!!! ///
        $pdf->loadHTML($html)->output();

        /**
         * PDF PATH FOR DEVIS OR FACTURE
         */
        switch (strtoupper($type)) {
            case 'DEVIS':
                $pdfPath = 'storage/pdfs/devis/' . $data['serie'] . '.pdf';
                break;
            case 'FACTURE':
                $pdfPath = 'storage/pdfs/factures/' . $data['serie'] . '.pdf';
                break;
        };

        // enregister localement
        $pdf->save($pdfPath, true);

        // ajout de path de pdf generer
        $data['pdfPath'] = $pdfPath;

        // supprimer l'atribut image de table $data
        unset($data['image']);

        /**
         * CREATION D'UNE INSTANCE DE DEVIS OU FACTURE
         */
        switch (strtoupper($type)) {
            case 'DEVIS':
                $devis = Devi::createOrFirst([
                    'tarif_ht' => $data['prixHT'],
                    'tarif_ttc' => $data['TTC'],
                    'tva' => $data['TVA'],
                    'devi_pdf' => $data['pdfPath'],
                    'parentmodel_id' => $data['parent']->parentmodel->id,
                    'demande_id' => $demande_id,
                    //'date_expiration'=>$expiration,
                ]);
                $data['devis'] = $devis->id;
                break;

            case 'FACTURE':
                $facture = facture::createOrFirst([
                    'devi_id' => $data['devis_id'],
                    'facture_pdf' => $data['pdfPath'],
                    'serie' => $data['serie'],
                ]);
                $data['facture'] = $facture->id;
                break;
        }

        return $data;
    }

    /**
     * 1. the parent  chooses childrens to enroll after he clicked on the offer
     * 2. we retrieve the activities attached to the offer
     * 3.retrieve the paiement id
     * 4. retrieve the auth parent
     * 5. create demande
     * 6. check if the demande is valid
     * 7.if true generate devis ,:) happy happy
     * 8. if false return sad :( :(
     * 9. notify the user in both cases
     */
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
                'date_demande' => now(),
            ]);

            // Fill the pivot table for each child and each activity
            foreach ($childrenIds as $childId) {
                foreach ($allActivities as $activity) {
                    $demande->getActvites()->attach($activity->id, ['enfant_id' => $childId]);
                }
            }

            // check the validation of demande + send notification in both cases
            if (!DemandeController::checkDemande($demande->id))
                return response()->json(['message' => 'Demands doesn\'t meet the requirements.']);
            else {
                // Generate a devis for the parent after filling the pivot table
                $data = $this->createDevis($demande->id);
                $devis = Devi::findOrFail($data['devis'])->makeHidden(['created_at', 'updated_at']);

                return response()->json([
                    'message' => 'Devis generated successfully for selected children in all activities in the offer',
                    'devis' => $devis
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to generate devis: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to generate devis: ' . $e->getMessage()], 500);
        }
    }

    public function overview($demandeId)
    {
        $data = DeviController::createDevis($demandeId, 'devis', false);
        if (is_array($data) && isset($data['error'])) {
            // handle error, for example, return it as a response
            return response()->json(['error' => $data['error']], $data['status_code'] ?? 500);
        }
        foreach ($data['enfantsActivites'] as $key => $item) {
            $newData = [
                'enfant' => $item['enfant'],
                'activite' => $item['activite'],
            ];
            $data['enfantsActivites'][$key] = $newData;
        }
        return response()->json($data);
    }
    public function downloadDevis($demande_id)
    {
        $user = Auth::User();
        $parent = $user->parentmodel;
        $demande = $parent->demandes()->find($demande_id);

        $devis = $demande->devi;
        $devisPath = $devis->devi_pdf;
        return response()->download($devisPath);
    }
    public function validateDevis($demande_id)
    {
        // Retrieve the devis :)
        $demande = demande::findOrFail($demande_id);
        $devis = $demande->devi;
        $devis->statut = 'valide';
        $devis->save();

        // Retrieve the  demande :(
        $demande->statut = 'en cours';
        $demande->save();

        $data = DeviController::createDevis($demande->id, 'facture');

        $facture = facture::findOrFail($data['facture'])->makeHidden(['created_at', 'updated_at']);

        // Generate a notification for all admins
        $notification = new notification([
            'type' => 'Devis Validated',
            'contenu' => 'A new devis has been validated of the user Nº' . $demande->parentmodel->id,
        ]);
        $notification->save();
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin)
            $notification->users()->attach($admin->id, ['date_notification' => date('Y-m-d')]);

        return response()->json([
            'message' => 'devis validee avec succes. Facture generated successfully for selected children in all activities in the offer',
            'facture' => $facture
        ]);
    }
    public function refuseDevis($demande_id)
    {
        $user = Auth::User();
        $parent = $user->parentmodel;

        $demande = $parent->demandes()->findOrFail($demande_id);
        $demande->update(['statut' => 'refuse']);

        $devis = $demande->devi;
        $devis->statut = 'refuse';
        $devis->save();

        return response()->json([
            'message' => 'devis refusé avec succes',
        ]);
    }
    public function motifRefuse(Request $request, $demande_id) // {motif:text}
    {
        // validate input ...

        $user = Auth::User();
        $parent = $user->parentmodel;
        $demande = $parent->demandes()->findOrFail($demande_id);
        $devis = $demande->devi;

        $devis->motif_refus = $request['motif'];
        $devis->save();
        $devis->demande()->update(['statut' => 'refuse']);

        return response()->json([
            'message' => 'votre motif a ete bien envoyer.',
            'devis' => $devis,
        ]);
    }

    /**
     * Genérer une Facture INSTANCE + PDF
     */
    public function createFacture($demande_id)
    {
        $data = DeviController::createDevis($demande_id, 'facture');

        $facture = facture::findOrFail($data['facture'])->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'message' => 'Facture generated successfully for selected children in all activities in the offer',
            'facture' => $facture
        ]);
    }

    /**
     * TELECHARGER LA FACTURE D'UNE DEMANDE DONNÉE
     */
    public function downloadFacture($demande_id)
    {
        $user = Auth::User();
        $parent = $user->parentmodel;
        $demande = $parent->demandes()->find($demande_id);

        $facture = $demande->devi->facture;
        $facturePath = $facture->facture_pdf;
        return response()->download($facturePath);
    }
    /**
     * Ajouter au panier une activité avec ses enfants.
     */
    public function addToPanier(Request $request, $activity_id)
    {
        $activite = activite::findOrFail($activity_id);
        $parent_id = Auth::user()->parentmodel->id;
        // i changed the validation according to mr gpt recommendation :)
        $validatedData = $request->validate([
            'enfants' => 'required|array',
            'enfants.*' => [
                'required',
                'exists:enfants,id',
                Rule::exists('enfants', 'id')->where(function ($query) use ($parent_id) {
                    $query->where('parentmodel_id', $parent_id);
                }),
            ],
        ]);

        foreach ($validatedData['enfants'] as $enfant_id) {
            $enfant = enfant::findOrFail($enfant_id);

            $enfant->activitesPanier()->attach($activity_id, [
                'parentmodel_id' => $parent_id,
                'status' => 'en attente'
            ]);
        }

        return response()->json([
            'message' => 'article ajouteé a votre panier avec succes',
            'Panier' => DeviController::getPanier($parent_id),
        ]);
    }

    /**
     * Modifier le painer en modifiant un enfant d'une activité choisie
     */
    public function modifyPanier(Request $request, $activity_id, $enfant_id)
    {
        $parent = Auth::user()->parentmodel;

        $activite = $parent->getActivites()->find($activity_id);

        // i changed the validation according to mr gpt recommendation :)
        $validatedData = $request->validate([
            'enfant' => [
                'sometimes',
                'exists:enfants,id',
            ],
        ]);
        if (!$parent->getEnfants()->find($enfant_id) || !$activite)
            return response()->json(['Error' => 'enfant non existant ou activité non existant']);
        // non redendance
        if (!$activite->enfantsPanier()->where('id', $validatedData['enfant'])->where('id', '<>', $enfant_id)->exists()) {

            $activite->enfantsPanier()->updateExistingPivot($enfant_id, ['enfant_id' => $validatedData['enfant']]);
        } else {
            return response()->json([
                'Error' => 'enfant deja existant, dans cette activité',
            ]);
        }

        return response()->json([
            'message' => 'Panier Modifier avec succes',
            'Panier' => DeviController::getPanier($parent->id),
        ]);
    }

    public function deleteActiviteFromPanier($activite_id)
    {
        $parent = Auth::user()->parentmodel;
        try {
            $parent->getActivites()->detach($activite_id);

            return response()->json([
                'message' => 'Activite supprimer de panier avec succes',
                'Panier' => DeviController::getPanier($parent->id),
            ]);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }

    /**
     * retourner le panier courant d'un etulisateur donneé
     * type de retour  Panier[ Activité{id, titre}, Enfants[{id, nom, prenom}] ]
     *
     * @param int $parent_id
     * @return array
     */
    protected static function getPanier($parent_id)
    {
        $panier = [];
        foreach (parentmodel::find($parent_id)->getActivites()->select(['id', 'titre'])->distinct('id')->get()->makeHidden('pivot') as $activite) {
            $enfants = array();
            foreach ($activite->enfantsPanier()->select(['id', 'prenom', 'nom'])->wherePivot('parentmodel_id', $parent_id)->orderBy('id')->get()->makeHidden('pivot') as $enfant) {
                $enfants[] = $enfant;
            };
            $panier[] = [
                'Activite' => $activite,
                'Enfants' => $enfants,
            ];
        }

        return $panier;
    }

    /**
     * Affiche le panier d'etulisateur courant
     */
    public function showPanier()
    {
        $parent_id = Auth::user()->parentmodel->id;
        return response()->json(['Panier' => DeviController::getPanier($parent_id)]);
    }

    /**
     * Supprimer le panier d'etulisateur courant
     */
    public function SupprimerPanier()
    {
        $parent = Auth::user()->parentmodel;

        // ya rbi tkhdm :) // khedmat yalili :]
        $parent->getActivites()->wherePivot('parentmodel_id', $parent->id)->detach();

        return response()->json([
            'message' => 'Votre panier est videé avec succes.'
        ]);
    }

    /**
     * Valider le panier afin de proceder la demande
     * 1- creation de demande
     * 2- remplire la table pivot 'enfant_demande_activite' ==> PGSQL
     */
    public function validerPanier()
    {
        $parent = Auth::user()->parentmodel;
        $activites = $parent->getActivites()->distinct('id')->get();

        foreach ($activites as $activite)
            $activite->getparentmodels()->updateExistingPivot($parent->id, ['status' => 'valide']);

        $demande = Demande::create(
            [
                'date_demande' => now(),
                'parentmodel_id' => $parent->id,
            ]
        );

        /**
         * le Travail de Anass de remplire la table pivot
         */

        return response()->json([
            'message' => 'Votre panier est validé.',
            'demande_id' => $demande->id,
        ]);
    }

    /**
     * DELETE DEVIS/FACTURE WITH PDF
     */
    public static function deletePDF($demande_id, $type = 'Devis')
    {
        $devis = Demande::findOrFail($demande_id)->devi;

        switch (strtoupper($type)) {
            case 'DEVIS':
                $pdfPath = $devis->devi_pdf;
                Storage::disk('storage')->delete($pdfPath);
                $devis->delete();
                break;
            case 'FACTURE':
                $facture = $devis->facture;
                $pdfPath = $facture->facture_pdf;
                Storage::disk('storage')->delete($pdfPath);
                $facture->delete();
                break;
        }

        return response()->json(['message' => 'votre ' . strtolower($type) . ' supprimmeé avec succes.']);
    }

    /**
     * TELECHARGER LE REÇU D'UNE DEMANDE DONNÉE ET D'UNE TRAITE DONNÉE
     */
    public function downloadRecu($demande_id, $traite)
    {
        $user = Auth::User();
        $parent = $user->parentmodel;
        $demande = $parent->demandes()->find($demande_id);

        $facture = $demande->devi->facture;
        $recu = $facture->recus()->where('tarite', $traite)->first();

        $recuPath = $recu->recu_pdf;
        return response()->download($recuPath);
    }
}
