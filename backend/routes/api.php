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

    // Manipulation des enfants
    Route::apiResource('enfants', EnfantController::class);
    // visuasilation des offres disponible 
    Route::get('/offres', [ParentmodelController::class, 'getoffers']);
    Route::get('/offres/{id}', [ParentmodelController::class, 'showoffer']);
    Route::post('offres/{offreid}/demandes',[DeviController::class,'chooseofferAndGenerateDevis']); // this one
    
    //the father can check the commandes he submitted that are en cours
    Route::get('demandes', [DemandeController::class, 'demandes']);
    //the parent get different notifications 
    Route::get('/notifications', [NotificationController::class,'indexparent']);
    // edt for a given student from Request
    Route::get('/EDT',[ParentmodelController::class,'EDT']);

    
    //profile(needs to be tested)
    Route::get('profile', [ProfileController::class, 'getprofileparent']);
    Route::put('profile/{id}', [ProfileController::class, 'updateparent']);
    Route::put('profile/{id}/password', [ProfileController::class, 'updatePassword']);
    Route::post('profile/{id}/photo', [ProfileController::class, 'updatePhoto']);
    Route::delete('profile/{id}', [ProfileController::class, 'deleteprofile']);
    
    
    /* ----- PANIER ----- */
    Route::post('activite/{activity_id}/add', [deviController::class,'addToPanier']);
    Route::prefix('panier')->group(function (){
        
        Route::put('activite/{activity_id}/enfants/{enfant_id}', [deviController::class,'modifyPanier']);
        Route::get('show', [DeviController::class, 'showPanier']);
        Route::delete('delete', [DeviController::class, 'SupprimerPanier']);
        Route::get('valide',[DeviController::class, 'validerPanier']);
        /* --- ACTIVITÉS DE PANIER --- */
        Route::delete('activites/{activite}', [DeviController::class, 'deleteActiviteFromPanier']);
    });

    /* ---- DEMANDE ---- */
    Route::prefix('demandes')->group(function (){
        Route::post('{demande}/delete', [DemandeController::class , 'deleteDemande']);
        Route::get('{id}/check', [DemandeController::class, 'checkDemandeAndGeneratePacks']);
        Route::post('{demande}/pack',[DemandeController::class, 'chosePack']);
        Route::post('{demande}/OP',[DemandeController::class, 'choseOP']);
        Route::post('{demande}/submit',[DemandeController::class, 'finishDemande']); // + Devis
    });

    /* --- DEVIS --- */
    Route::get('demandes/{demandeid}/overview',[DeviController::class,'overview']);
    Route::get('demandes/{demande_id}/downloadDevis',[DeviController::class,'downloadDevis']);
    // Valider et refuser devis
    Route::post('devis/{devis}/validate',[DeviController::class, 'validateDevis']); // by Taha
    Route::post('devis/{devis}/refuse', [deviController::class, 'refuseDevis']); // by Sakhri
    // Motif au cas de refus
    Route::post('devis/{devis}/refuse/motif',[DeviController::class, 'motifRefuse']);

    /* --- FACTURE --- */
    Route::get('demandes/{demande_id}/facture',[DeviController::class, 'createFacture']);
    Route::get('demandes/{demande_id}/downloadFacture', [DeviController::class, 'downloadFacture']);
    /** --- PDFs --- */
    Route::delete('demandes/{demande_id}/{type}/delete',[DeviController::class, 'deletePDF']);
});


// Routes réservées à l'animateur
Route::middleware([CheckRole::class . ':' . User::ROLE_ANIMATEUR])->prefix('animateur')->group(function () {
    // Horaires CRUD
    Route::get('horaires', [AnimateurController::class, 'indexHeures'])->name('animateur.horaires.index');
    Route::post('horaires', [AnimateurController::class, 'storeHeure'])->name('animateur.horaires.store');
    Route::get('getHoraires', [AnimateurController::class, 'getHeures'])->name('animateur.horaires.get');

    Route::put('horaires/{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');
    Route::patch('horaires/{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');

    Route::delete('horaires/{horaire}', [AnimateurController::class, 'destroyHeure'])->name('animateur.horaires.destroy');
    // EDT
    Route::get('edt', [AnimateurController::class, 'getEDT'])->name('animateur.edt');
    // Activites
    Route::get('activites', [AnimateurController::class, 'indexActivite'])->name('animateur.activites');
    Route::get('activites/{activite}', [AnimateurController::class, 'showActivite'])->name('animateur.activites.show');
    Route::get('activites/{activite}/etudiants/{etudiant}', [AnimateurController::class, 'showEtudiant'])->name('animateur.activites.show');
    //hardship always repay
    Route::get('profile', [ProfileController::class, 'getprofileanimateurs'])->name('animateur.profile');
    Route::put('profile/{id}', [ProfileController::class, 'updateanimateur'])->name('animateur.profile.update');
    Route::put('profile/{id}/password', [ProfileController::class, 'updatePassword'])->name('animateur.profile.update-password');
    Route::post('profile/{id}/photo', [ProfileController::class, 'updatePhoto'])->name('animateur.profile.update-photo');
    Route::delete('profile/{id}', [ProfileController::class, 'deleteprofile'])->name('animateur.profile.delete-profile');


    //notification
    Route::get('notifications', [NotificationController::class, 'indexanimateur']);
});




// Routes réservées à l'admin
Route::middleware([CheckRole::class . ':' . User::ROLE_ADMIN])->prefix('admin')->group(function () {

    // Administrateur routes
    Route::get('admins', [AdministrateurController::class, 'index']);
    Route::post('admins', [AdministrateurController::class, 'store']);
    Route::get('admins/{admin}', [AdministrateurController::class, 'show']);
    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('admins/{admin}', [AdministrateurController::class, 'update']);
    Route::delete('admins/{admin}', [AdministrateurController::class, 'destroy']);

    // Animateurs routes
    Route::get('animateurs', [AnimateursController::class, 'index']);
    Route::post('animateurs', [AnimateursController::class, 'store']);
    Route::get('animateurs/{animateur}', [AnimateursController::class, 'show']);
    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('animateurs/{animateur}', [AnimateursController::class, 'update']);
    Route::delete('animateurs/{animateur}', [AnimateursController::class, 'destroy']);

    // Parents routes
    Route::get('parents', [ParentmodelController::class, 'index']);
    Route::post('parents', [ParentmodelController::class, 'store']);
    Route::get('parents/{parent}', [ParentmodelController::class, 'show']);
    //i eliminate the capability of the admin to update any informations for the users
    //Route::put('parents/{parent}', [ParentmodelController::class, 'update']);
    Route::delete('parents/{parent}', [ParentmodelController::class, 'destroy']);


    Route::apiResource('packs', PackController::class);
    //Route::apiResource('paiements',paiementController::class);


    //activite
    Route::get('activities', [ActiviteController::class, 'index']);

    Route::post('activities', [ActiviteController::class, 'store']);
    Route::get('activities/{activity}', [ActiviteController::class, 'show']);
    Route::put('activities/{activity}', [ActiviteController::class, 'update']); // need to be revised
    Route::delete('activities/{activity}', [ActiviteController::class, 'destroy']);

    // option de paiement d activite (avec remise) --- new
    Route::post('activities/{activity}/paiements', [ActiviteController::class, 'storeOP']);
    Route::put('activities/{activity}/paiements/{paiement}', [ActiviteController::class, 'updateOP']);
    Route::delete('activities/{activity}/paiements/{paiement}', [ActiviteController::class, 'destroyOP']);

    //horaire d activite
    Route::get('activities/{activity}/horaires/{horaires}', [ActiviteController::class, 'showhoraire']);
    Route::get('activities/{activity}/horaires', [ActiviteController::class, 'indexhoraires']);
    Route::delete('activities/{activity}/horaires/{horaires}', [ActiviteController::class, 'detachhoraire']);
    Route::post('activities/{activity}/horaires', [ActiviteController::class, 'choosehoraire']);


    //horaire --not functional
    //Route::apiResource('horaires', HoraireController::class);

    Route::apiResource('offres', offreController::class);

    //these two route are disabled , no use , no value ,no logic
    // Define route for attaching activities to an offer
    //Route::put('/offers/{offerId}/attach-activities', [OffreController::class, 'attachActivities']);

    // Define route for detaching activity from offer
    //Route::put('/offers/{offerId}/detach-activity', [OffreController::class, 'detachActivity']);

    //available-activities with available animators, remember that we need also to filter with domaine competence
    //check for the activity with two horaires 
    Route::get('/available-activities', [ActiviteController::class, 'getAvailableActivities']);
    Route::get('/available-activities/{activity_id}/available-animators', [ActiviteController::class, 'getAvailableAnimatorsForActivity']);
    Route::post('/available-activities/{activity_id}/available-animators/{animator_id}/assign-animators', [ActiviteController::class, 'assignAnimatorToActivity']);

    //i need to adjust theese function to generate motife for refuse
    Route::get('/demandes', [AdministrateurController::class, 'getdemandes']);

    // Consultation des enfants
    Route::apiResource('enfants', EnfantController::class)->only(['index', 'show']);

Route::post('/demandes/{demande}/validate',[DemandeController::class, 'payeDemande']);
    //profile(needs to be tested)
    Route::get('profile', [ProfileController::class, 'getprofileadmin']);
    Route::put('profile/{id}', [ProfileController::class, 'updateadmin']);
    Route::put('profile/{id}/password', [ProfileController::class, 'updatePassword']);
    Route::post('profile/{id}/photo', [ProfileController::class, 'updatePhoto']);
    Route::delete('profile/{id}', [ProfileController::class, 'deleteprofile']);

    //notification
    Route::get('notifications', [NotificationController::class, 'indexadmin']);

    Route::post('/activite/{activity_id}/add', [deviController::class,'addToPanier']);

    
});




// ----- en test ----- //
Route::apiResource('devis', deviController::class);
Route::apiResource('notifications', NotificationController::class);
Route::apiResource('demandes', DemandeController::class);
Route::get('checkDemande/{id}',[DemandeController::class, 'checkDemande']);

// Route::get('getDevis',[deviController::class, 'getDevis']);    // marche
// Route::get('devis',[deviController::class, 'createDevis']);    // marche
// Route::get('monPack',[PackController::class,'packPoussible']); // marche

Route::get('getDevis', [deviController::class, 'getDevis']);
Route::get('devis', [deviController::class, 'createDevis']);
Route::get('monPack', [PackController::class, 'packPoussible']);

//------test----taha----ostora----//
// Validate demande route
Route::post('/demandes/{demande}/validate', [AdministrateurController::class, 'validated']);

// Refuse demande route
Route::post('/demandes/{demande}/refuse',[AdministrateurController::class,'refuse']);


Route::post('/demandes/{demande}/refuse', [AdministrateurController::class, 'refuse']);

