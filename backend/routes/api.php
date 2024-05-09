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
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/forget',[ForgotController::class,'forget']);
Route::post('/reset',[ForgotController::class,'reset']);

//route qui necessite l'authentification
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});








// Routes réservées aux parents
Route::middleware(['check.role'.':' . User::ROLE_PARENT])->prefix('parent')->group(function () {

    // Manipulation des enfants
    Route::apiResource('enfants',EnfantController::class); 
    // visuasilation des offres disponible 
    Route::get('/offres', [ParentmodelController::class, 'getoffers']);
    Route::get('/offres/{id}', [ParentmodelController::class, 'showoffer']);
    //the father can check the commandes he submitted that are en cours
    Route::get('demandes',[DemandeController::class,'demandes']);
    //the parent get different notifications 
    Route::get('/notifications', [NotificationController::class,'indexparent']);
});


// Routes réservées à l'animateur
Route::middleware([CheckRole::class .':'. User::ROLE_ANIMATEUR])->prefix('animateur')->group(function ()
{
    // Horaires CRUD
    Route::get('horaires', [AnimateurController::class, 'indexHeures'])->name('animateur.horaires.index');
    Route::post('horaires', [AnimateurController::class, 'storeHeure'])->name('animateur.horaires.store');
    Route::get('getHoraires', [AnimateurController::class, 'getHeures'])->name('animateur.horaires.get');

    Route::put('horaires/{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');
    Route::patch('horaires/{horaire}', [AnimateurController::class, 'updateHeure'])->name('animateur.horaires.update');

    Route::delete('horaires/{horaire}', [AnimateurController::class, 'destroyHeure'])->name('animateur.horaires.destroy');
    // EDT
    Route::get('edt',[AnimateurController::class, 'getEDT'])->name('animateur.edt');
    // Activites
    Route::get('activites',[AnimateurController::class, 'indexActivite'])->name('animateur.activites');
    Route::get('activites/{activite}',[AnimateurController::class, 'showActivite'])->name('animateur.activites.show');
    Route::get('activites/{activite}/etudiants/{etudiant}',[AnimateurController::class, 'showEtudiant'])->name('animateur.activites.show');
});


// Routes réservées à l'admin
Route::middleware([CheckRole::class .':'. User::ROLE_ADMIN])->prefix('admin')->group(function ()
{
    
Route::apiResource('admins',AdministrateurController::class);
Route::apiResource('animateurs',AnimateursController::class);
Route::apiResource('parents',ParentmodelController::class);


Route::apiResource('packs',PackController::class);
Route::apiResource('paiements',paiementController::class);


//activite
Route::get('activities', [ActiviteController::class, 'index']);

Route::post('activities', [ActiviteController::class, 'store']);
Route::get('activities/{activity}', [ActiviteController::class, 'show']);
Route::put('activities/{activity}', [ActiviteController::class, 'update']);
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
//horaire
Route::apiResource('horaires',HoraireController::class);

Route::apiResource('offres',offreController::class);

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
Route::get('/demandes',[AdministrateurController::class,'getdemandes']);

// Consultation des enfants
Route::apiResource('enfants',EnfantController::class)->only(['index','show']);

});




// ----- en test ----- //
Route::apiResource('devis',deviController::class);
Route::apiResource('notifications',NotificationController::class);
Route::apiResource('demandes',DemandeController::class);

Route::get('getDevis',[deviController::class, 'getDevis']);
Route::get('devis',[deviController::class, 'createDevis']);
Route::get('monPack',[PackController::class,'packPoussible']);

//------test----taha----ostora----//
// Validate demande route
Route::post('/demandes/{demande}/validate', [AdministrateurController::class,'validated']);

// Refuse demande route
Route::post('/demandes/{demande}/refuse',[AdministrateurController::class,'refuse']);
