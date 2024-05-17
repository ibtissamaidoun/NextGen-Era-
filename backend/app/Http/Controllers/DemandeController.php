<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\devi;
use App\Models\pack;
use App\Models\enfant;
use App\Models\demande;
use App\Models\paiement;
use App\Models\parentmodel;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    //taha partie , //pour parent
    public function demandes(Request $request)
    //taha partie 
    public function demandes(Request $request)
    {
        try {
            // Retrieve the authenticated parent's ID from the parentmodels table
            $user = $request->user();
            $parent = parentmodel::where('user_id', $user->id)->firstOrFail();

            // Retrieve all demandes associated with the parent
            $demandes = $parent->demandes()->where('statut','en cours')->get();
    
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


    // unbelivable collaboration with two of the greatest in the industry Taha & Sakhri

    /**
     * check if the demande is OK (return true) with the detadase or NOT (reurn false)
     * the user is notified in both cases
     * TRUE -> go pay
     * FALSE -> demande annuler
     * 
     * @param bool $statut
     */
    public static function checkDemande( $demande_id )
    {
        $demande = demande::findOrFail($demande_id);
        
        $activities = $demande->getActvites()->distinct('id')->get();

        $statut = true;
        
        // Check if adding these children exceeds the maximum capacity for any activity, its smart from my part
        foreach ($activities as $activity)
        {
            // Retrieve all children associated with the activity, the power of relations
            $children = $activity->getEnfants()->distinct('id')->get();
            $childrenCount = $children->count();

            if ($activity->effectif_actuel + $childrenCount > $activity->effectif_max)
            {
                $error =  'Validation denied. Maximum capacity reached for one or more activities.';
                $statut = false;
            }

            // check the age of all children if is in the range of all activities
            foreach ($children as $child) {
                $date_naissance = Carbon::parse($child->date_de_naissance);
                $age = $date_naissance->diffInYears(Carbon::now());
                if ($age > $activity->age_max || $age < $activity->age_min) {
                    $error = 'Validation denied. Maximum or minimum age is exided for one or more activities.';
                    $statut = false;
                }
            }
        }

        if($statut)
            // Generate a notification for the user
            $notification =notification::create([
                'type' => 'Demande Validated',
                'contenu' => 'Your demande has been validated.',
            ]);
        else
            // Generate a notification for all admins
            $notification = notification::create([
                'type' => 'Demande Refused',
                'contenu' => $error,
            ]);

        $parent = $demande->parentmodel()->first();

        $notification->users()->attach($parent->id, ['date_notification' => now()]);
        // true if all goes fine || false if not done
        return $statut;
    }
    /**
     * admin valide la demande
     * 
     * 
     * if payed :
     *     - affect children to there activities. -> EDT
     *     - demande statut = paye.
     *     - the user is notified.
     * -->TODO: create recu.
     */
    public function payeDemande($demande_id)
    {
        
        $statut = DemandeController::checkDemande($demande_id);

        if (!$statut)
            return response()->json(['message' => 'Demande non valider !']);


        $demande = demande::findOrFail($demande_id);
        $activities = $demande->getActvites()->distinct('id')->get();

        // Retrieve all children associated with the demande, the power of relations
        $children = $demande->getEnfants()->distinct('id')->get();

        // --->>> FOR ACTIVITES
        if ($demande->pack()->first() && !$demande->offre()->first()) {
            $data = DeviController::createDevis($demande_id);
            $activiteStudents = $data['enfantsActivites'];
            foreach ($activiteStudents as $actStud) {
                $child = $actStud['enfantData'];

                $activity = $actStud['activiteData'];
                $activity->effectif_actuel += 1;
                $activity->save();

                // retrieve the activity horaires
                $horaires = $activity->horaires()->get();
                // remplire la table EDT
                $child->activites()->attach($activity->id, [
                    'horaire_1' => $horaires[0]->id,
                    'horaire_2' => $horaires[1]->id
                ]);
            }
        }
        // --->>> FOR OFFRE
        elseif (!$demande->pack()->first() && $demande->offre()->first()) {
            // If capacity is not exceeded, add children to activities and update their schedules in emploi du temps
            foreach ($children as $child) {
                foreach ($activities as $activity) {
                    $activity->effectif_actuel += 1;
                    $activity->save();

                    // retrieve the activity horaires
                    $horaires = $activity->horaires()->get();
                    // remplire la table EDT
                    $child->activites()->attach($activity->id, [
                        'horaire_1' => $horaires[0]->id,
                        'horaire_2' => $horaires[1]->id
                    ]);
                }
            }
        }

        // Update the status of the demande :) i am happy if it reaches this
        $demande->statut = 'paye';
        $demande->administrateur_id = (Auth::user())->administrateur->id;
        $demande->save();

        // TODO : facture paye

        // TODO : create recu

        // notifier le parent 
        $notification = notification::create([
            'type' => 'Facture Payee',
            'contenu' => 'Votre Facture de ' . Carbon::now()->format('Y-m') . ' a ete bien payee',
        ]);
        $parent = $demande->parentmodel()->first();
        $notification->users()->attach($parent->id, ['date_notification' => now()]);


        return response()->json(['message' => 'Demande validated and children placed in activities successfully.']);
    }

    /**
     * Delete demande refused -Fuction-
    */
    public function deleteDemande($demande_id)
    {
        $parent = Auth::user()->parentmodel;
        $demande =  $parent->demandes()->findOrFail($demande_id);
        
        if ($demande->statut === 'en cours')
        {
            $demande->delete();
            return response()->json(['message' => 'we are sorry thet you refused to pay :\'('], 200);
        }
        else
        {
            return response()->json(['message' => 'Only demandes with status "en cours" can be deleted'], 400);
        }
    }
     
    /**
     * Proceder la creation de Demande -1- 
     * 1- check demande
     * 2- pack poussible
     * return les pack poussible (succes)
     */
    public function checkDemandeAndGeneratePacks($demande_id)
    {
        $parent = Auth::user()->parentmodel;
        $demande =  $parent->demandes()->findOrFail($demande_id);
        
        // si la demande n'est pas valide
        if(! DemandeController::checkDemande($demande->id) )
        {
            $demande->delete();
            return response()->json([
                'message' => 'Votre demande n\'est pas valide, d\'où il est supprimeé.',
            ], 403);
        }

        // la demande est valide
        $myPacks = array();
        foreach(PackController::packPoussible($demande->id) as $id)
        {
            $myPacks[] =Pack::select(['id','type'])->find($id);
        }
        
        return response()->json([
            'message' => 'Votre demande est valide',
            'packPoussible' => $myPacks,
        ]);
    }

    /**
     * Affecter un pack possible au Demande encours
    */
    public function chosePack(Request $request, $demande_id)
    {
        $validated = $request->validate([
            'pack' => 'exists:packs,id'
        ]);
        
        $parent = Auth::user()->parentmodel;
        $demande =  $parent->demandes()->findOrFail($demande_id);

        $demande->update(['pack_id'=> $validated['pack']]);

        $myPack = Pack::select(['id','type'])->find($validated['pack']);

        return response()->json([
            'message' => 'Votre \'Pack '.$myPack->type.'\' est bien ajouteé à votre demande.',
            'demande' => $demande,
        ]);
    }

    /**
     * Afecter un Option De Paiment possible au Demande encours
     */
    public function choseOP(Request $request, $demande_id)
    {
        $validated = $request->validate([
            'optionPaiment' => 'exists:paiements,id'
        ]);

        $parent = Auth::user()->parentmodel;
        $demande =  $parent->demandes()->findOrFail($demande_id);

        $demande->update(['paiement_id'=> $validated['optionPaiment']]);

        $myOP = paiement::select(['id', 'option_paiement'])->find($validated['optionPaiment']);

        return response()->json([
            'message' => 'Votre Option de paiment : \''.$myOP->option_paiement.'\' est bien ajouteé à votre demande.',
            'demande' => $demande,
        ]);
    }

    /**
     * Create Devis for Packs Activitées
    */
    public function finishDemande($demande_id)
    {
        // Generate a devis for the parent after filling the pivot table
        $data = DeviController::createDevis($demande_id);
        $devis = devi::findOrFail($data['devis'])->makeHidden(['created_at','updated_at']);
        
         return response()->json(['message' => 'Devis generated successfully for selected children in all activities in the offer',
                                  'devis'=>$devis]);
    }
    
    
}
