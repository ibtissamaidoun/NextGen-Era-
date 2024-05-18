<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\enfant;
use App\Models\demande;
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

    //taha partie 
     public function demandes(Request $request)
    {
        try {
            // Retrieve the authenticated parent's ID from the parentmodels table
            $user = $request->user();
            $parent = parentmodel::where('user_id', $user->id)->firstOrFail();
    
            // Retrieve all demandes associated with the parent
            $demandes = $parent->demandes()->get();
    
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
     * check if the demande is OK (return true) with the detadase or NOT (return false)
     * the user is notified in both cases
     * TRUE -> go pay
     * FALSE -> demande annuler
     * 
     * @param bool $statut
     */
    public static function checkDemandeOffre( $demande_id )
    {
        $demande = demande::findOrFail($demande_id);
        $activities = $demande->offre()->first()->activites;

        $statut = true;

        // Retrieve all children associated with the demande, the power of relations
        $children = $demande->getEnfants()->distinct('id')->get();
        $childrenCount = $children->count();

        // Check if adding these children exceeds the maximum capacity for any activity, its smart from my part
        foreach ($activities as $activity) {
            if ($activity->effectif_actuel + $childrenCount > $activity->effectif_max) {
                $error =  'Validation denied. Maximum capacity reached for one or more activities.';
                $statut = false;
            }

            // check the age of all children if is in the range of all activities
            foreach($children as $child)
            {
                $date_naissance = Carbon::parse($child->date_de_naissance);
                $age = $date_naissance->diffInYears(Carbon::now());
                if( $age > $activity->age_max || $age < $activity->age_min){
                    $error = 'Validation denied. Maximum or minimum age is exided for one or more activities.';
                    $statut = false;
                }
            }
        }

        if($statut)
            // Generate a notification for all admins
            $notification =notification::create([
                'type' => 'Demande Validated',
                'contenu' => 'Your demande has been validated.',
            ]);
        else
            // Generate a notification for all admins
            $notification =notification::create([
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
        
        $statut = DemandeController::checkDemandeOffre($demande_id);

        if(! $statut)
            return response()->json([ 'message' => 'Demande non valider !' ]);


        $demande = demande::findOrFail($demande_id);
        $activities = $demande->getActvites()->distinct('id')->get();

        // Retrieve all children associated with the demande, the power of relations
        $children = $demande->getEnfants()->distinct('id')->get();

        // --->>> FOR ACTIVITES
        if($demande->pack()->first() && ! $demande->offre()->first())
        {
            $data = DeviController::createDevis($demande_id);
            $activiteStudents = $data['enfantsActivites'];
            foreach($activiteStudents as $actStud)
            {
                $child = $actStud['enfantData'];
                
                $activity = $actStud['activiteData'];
                $activity->effectif_actuel += 1;
                $activity->save();

                // retrieve the activity horaires
                $horaires = $activity->horaires()->get();
                // remplire la table EDT
                $child->activites()->attach($activity->id,['horaire_1' => $horaires[0]->id,
                                                           'horaire_2' => $horaires[1]->id]);
            }
        }
        // --->>> FOR OFFRE
        elseif( !$demande->pack()->first() && $demande->offre()->first())
        {
            // If capacity is not exceeded, add children to activities and update their schedules in emploi du temps
            foreach ($children as $child) 
            {
                foreach ($activities as $activity) 
                { 
                    $activity->effectif_actuel += 1;
                    $activity->save();
                    
                    // retrieve the activity horaires
                    $horaires = $activity->horaires()->get();
                    // remplire la table EDT
                    $child->activites()->attach($activity->id,['horaire_1' => $horaires[0]->id,
                                                               'horaire_2' => $horaires[1]->id]);
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
        $notification =notification::create([
            'type' => 'Facture Payee',
            'contenu' => 'Votre Facture de '.Carbon::now()->format('Y-m').' a ete bien payee',
        ]);
        $parent = $demande->parentmodel()->first();
        $notification->users()->attach($parent->id, ['date_notification' => now()]);


        return response()->json(['message' => 'Demande validated and children placed in activities successfully.']);
    }

    /**
     * TODO : delete demande refused -Fuction-
     */

     
}
