<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\offreController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\paiementController;
use App\Http\Controllers\AnimateurController;
use App\Http\Controllers\AnimateursController;
use App\Http\Controllers\ParentmodelController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\deviController;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//routes public
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forget', [ForgotController::class, 'forget']);
Route::post('/reset', [ForgotController::class, 'reset']);

//route qui necessite l'authentification
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});








// Routes réservées aux parents
Route::middleware(['check.role' . ':' . User::ROLE_PARENT])->prefix('parent')->group(function () {

    /** ---- MANIPULATION DES ENFANTS ---- */
    Route::prefix('enfants')->group(function ()
    {
        Route::apiResource('/', EnfantController::class);

        // EDT POUR UN ENFANT DONNÉE
        Route::get('{enfant_id}/edt',[ParentmodelController::class,'EDT']);
    });

    
    
    /** ---- NOTIFICATIONS ---- */
    Route::apiResource('notifications', NotificationController::class);
    
    
    /** ---- PROFILE ---- */
    Route::prefix('profile')->group(function ()
    {
        Route::get('/', [ProfileController::class, 'getprofileparent']); // working
        Route::put('/', [ProfileController::class, 'updateparent']); // working
        Route::put('update/password', [ProfileController::class, 'updatePassword']); // working
        Route::post('update/photo', [ProfileController::class, 'updatePhoto']); 
        Route::delete('/', [ProfileController::class, 'deleteprofile']);
    });
    
    /** ---- PROCÉDURE DE CRÉATION D'UNE DEMANDE AVEC UNE OFFRE ---- */
    Route::get('offres', [ParentmodelController::class, 'getoffers']);
    Route::get('offres/{id}', [ParentmodelController::class, 'showoffer']);
    Route::post('offres/{offreid}/demande',[DeviController::class,'chooseofferAndGenerateDevis']); // + Devis
    
    /* ----- PANIER ----- */
    Route::post('activite/{activity_id}/add', [deviController::class,'addToPanier']);
    Route::prefix('panier')->group(function ()
    {
        Route::put('activite/{activity_id}/enfants/{enfant_id}', [deviController::class,'modifyPanier']);
        Route::get('show', [DeviController::class, 'showPanier']);
        
        /* --- SUPPRIMER UNE ACTIVITÉE DE PANIER --- */
        Route::delete('activites/{activite}', [DeviController::class, 'deleteActiviteFromPanier']);

        Route::delete('delete', [DeviController::class, 'SupprimerPanier']);
        Route::get('valide',[DeviController::class, 'validerPanier']);
    });

    /* ---- DEMANDE ---- */
    Route::prefix('demandes')->group(function ()
    {
        //the father can check the commandes he submitted that are en cours
        Route::get('/', [DemandeController::class, 'demandes']);

        Route::delete('{demande}/delete', [DemandeController::class , 'deleteDemande']);
        
        /** --- PROCÉDURE DE CRÉATION D'UNE DEMANDE AVEC UN PACK ---- */
        Route::get('{demande}/check', [DemandeController::class, 'checkDemandeAndGeneratePacks']);
        Route::post('{demande}/pack',[DemandeController::class, 'chosePack']);
        Route::post('{demande}/OP',[DemandeController::class, 'choseOP']);
        Route::post('{demande}/submit',[DemandeController::class, 'finishDemande']); // + Devis
        
        
        /* --- DEVIS (INCLU LES OFFRES) --- */
        Route::get('{demande}/overview',[DeviController::class,'overview']);
        Route::get('{demande}/download-devis',[DeviController::class,'downloadDevis']);
        // Valider et refuser devis
        Route::post('{demande}/devis/validate',[DeviController::class, 'validateDevis']); // + Génération de facture
        Route::post('{demande}/devis/refuse', [deviController::class, 'refuseDevis']); // by Sakhri
        // Motif au cas de refus
        Route::post('{demande}/devis/refuse/motif',[DeviController::class, 'motifRefuse']);
    
        /* --- FACTURE  (INCLU LES OFFRES)--- */
        //Route::get('{demande}/facture',[DeviController::class, 'createFacture']);
        Route::get('{demande}/download-facture', [DeviController::class, 'downloadFacture']);

        /** --- SUUPRIMER LES PDFs ---- TYPE = 'DEVIS' OR 'FACTURE' ---- */  
        Route::delete('{demande}/{type}/delete',[DeviController::class, 'deletePDF']);
    });

});










// Routes réservées à l'animateur
Route::middleware([CheckRole::class . ':' . User::ROLE_ANIMATEUR])->prefix('animateur')->group(function () 
{
    /** --- HORAIRES CRUD --- */
    Route::prefix('horaires')->group(function ()
    {
        Route::get('/', [AnimateurController::class, 'indexHeures'])->name('animateur.horaires.index');
        Route::post('/', [AnimateurController::class, 'storeHeure'])->name('animateur.horaires.store');
        Route::get('getHoraires', [AnimateurController::class, 'getHeures'])->name('animateur.horaires.get');
    
        Route::put('{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');
        Route::patch('{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');
    
        Route::delete('{horaire}', [AnimateurController::class, 'destroyHeure'])->name('animateur.horaires.destroy');
    });

    /** --- EDT --- */
    Route::get('edt', [AnimateurController::class, 'getEDT'])->name('animateur.edt');

    /* --- ACTIVITÉS DE PANIER --- */
    Route::get('activites', [AnimateurController::class, 'indexActivite'])->name('animateur.activites');
    Route::get('activites/{activite}', [AnimateurController::class, 'showActivite'])->name('animateur.activites.show');
    Route::get('activites/{activite}/etudiants/{etudiant}', [AnimateurController::class, 'showEtudiant'])->name('animateur.activites.show');

    /** --- PROFILE --- */
    Route::prefix('profile')->group(function ()
    {
        Route::get('/', [ProfileController::class, 'getprofileanimateurs'])->name('animateur.profile');
        Route::put('/', [ProfileController::class, 'updateanimateur'])->name('animateur.profile.update');
        Route::put('update/password', [ProfileController::class, 'updatePassword'])->name('animateur.profile.update-password');
        Route::post('update/photo', [ProfileController::class, 'updatePhoto'])->name('animateur.profile.update-photo');
        Route::delete('/', [ProfileController::class, 'deleteprofile'])->name('animateur.profile.delete-profile');
        
    });


    /** --- NOTIFICATIONS --- */
    Route::apiResource('notifications', NotificationController::class);
});











// Routes réservées à l'admin
Route::middleware([CheckRole::class . ':' . User::ROLE_ADMIN])->prefix('admin')->group(function () {

    /** --- ADMINS --- */
    Route::get('admins', [AdministrateurController::class, 'index']);
    Route::post('admins', [AdministrateurController::class, 'store']);
    Route::get('admins/{admin}', [AdministrateurController::class, 'show']);

    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('admins/{admin}', [AdministrateurController::class, 'update']);
    Route::delete('admins/{admin}', [AdministrateurController::class, 'destroy']);

    /** --- ANIMATEURS --- */
    Route::get('animateurs', [AnimateursController::class, 'index']);
    Route::post('animateurs', [AnimateursController::class, 'store']);
    Route::get('animateurs/{animateur}', [AnimateursController::class, 'show']);

    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('animateurs/{animateur}', [AnimateursController::class, 'update']);
    Route::delete('animateurs/{animateur}', [AnimateursController::class, 'destroy']);

    /** --- PARENTS --- */
    Route::get('parents', [ParentmodelController::class, 'index']);
    Route::post('parents', [ParentmodelController::class, 'store']);
    Route::get('parents/{parent}', [ParentmodelController::class, 'show']);

    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('parents/{parent}', [ParentmodelController::class, 'update']);
    Route::delete('parents/{parent}', [ParentmodelController::class, 'destroy']);

    /** --- PACKS --- */
    Route::apiResource('packs', PackController::class)->only('index');

    /** --- O. DE PAIEMENTS --- */      // j'ai elimine la poussibilité de l'admin a manipuler les option de paiements directement
    Route::apiResource('paiements',paiementController::class)->only('index');


    /** ---- ACTIVITÉES ---- */
    Route::prefix('activities')->group(function ()
    {
        Route::get('/', [ActiviteController::class, 'index']);
    
        Route::post('/', [ActiviteController::class, 'store']);
        Route::get('{activity}', [ActiviteController::class, 'show']);
        Route::put('{activity}', [ActiviteController::class, 'update']); // need to be revised
        Route::delete('{activity}', [ActiviteController::class, 'destroy']);
    
        /** --- OPTIONS DE PAIMENTS ASSOCIER AVEC UNE ACTIVITÉE */
        Route::post('{activity}/paiements', [ActiviteController::class, 'storeOP']);
        Route::put('{activity}/paiements/{paiement}', [ActiviteController::class, 'updateOP']);
        Route::delete('{activity}/paiements/{paiement}', [ActiviteController::class, 'destroyOP']);
    
        /** --- HORAIRES ASSOCIER AVEC UNE ACTIVITÉE */
        Route::get('{activity}/horaires/{horaires}', [ActiviteController::class, 'showhoraire']);
        Route::get('{activity}/horaires', [ActiviteController::class, 'indexhoraires']);
        Route::delete('{activity}/horaires/{horaires}', [ActiviteController::class, 'detachhoraire']);
        Route::post('{activity}/horaires', [ActiviteController::class, 'choosehoraire']);
        
        /** --- AVAILABLE ACTIVITIES --- */       // remember that we need also to filter with domaine competence
        //check for the activity with two horaires 
        Route::get('/available', [ActiviteController::class, 'getAvailableActivities']);
        Route::get('/available/{activity_id}/available-animators', [ActiviteController::class, 'getAvailableAnimatorsForActivity']);
        Route::post('/available/{activity_id}/available-animators/{animator_id}/assign-animators', [ActiviteController::class, 'assignAnimatorToActivity']);
    });


    /** --- HORAIRES --- */
    Route::apiResource('horaires', HoraireController::class);

    /** --- OFFRES --- */
    Route::apiResource('offres', offreController::class);

    /** --- CONSULTATION DES ENFANTS --- */
    Route::apiResource('enfants', EnfantController::class)->only(['index', 'show']);

    //i need to adjust theese function to generate motife for refuse
    Route::get('/demandes', [AdministrateurController::class, 'getdemandes']);

    /** --- FACTURE - PAYEMENT --- */
    Route::post('/demandes/{demande}/paye',[DemandeController::class, 'payeDemande']);
    Route::post('/demandes/{demande}/paye',);


    /** ---- MON PROFILE ---- */
    Route::prefix('profile')->group(function ()
    {
        Route::get('/', [ProfileController::class, 'getprofileadmin']);
        Route::put('/', [ProfileController::class, 'updateadmin']);
        Route::put('/update/password', [ProfileController::class, 'updatePassword']);
        Route::post('/update/photo', [ProfileController::class, 'updatePhoto']);
        Route::delete('/', [ProfileController::class, 'deleteprofile']);
    });

    /** ---- NOTIFICATIONS ---- */
    Route::apiResource('notifications', NotificationController::class);

});




// ----- en test ----- //
Route::apiResource('devis', deviController::class);
Route::apiResource('demandes', DemandeController::class);

Route::get('getRecu',function(){
    return view('pdfs.recuTemplate');
});    // marche
// Route::get('devis',[deviController::class, 'createDevis']);    // marche
// Route::get('monPack',[PackController::class,'packPoussible']); // marche

//------test----taha----ostora----//

