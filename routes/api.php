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
use App\Http\Controllers\deviController;

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

//route qui necessite l'authentification
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});








// Routes réservées aux parents
Route::middleware(['check.role'.':' . User::ROLE_PARENT])->prefix('parent')->group(function () {

});


// Routes réservées à l'animateur
Route::middleware([CheckRole::class .':'. User::ROLE_ANIMATEUR])->prefix('animateur')->group(function ()
{
    // Horaires CRUD
    Route::get('horaires', [AnimateurController::class, 'indexHeures'])->name('animateur.horaires.index');
    Route::post('horaires', [AnimateurController::class, 'storeHeure'])->name('animateur.horaires.store');
    Route::get('horaires/{horaire}', [AnimateurController::class, 'showHeure'])->name('animateur.horaires.show');

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

//horaire d activite

Route::get('activities/{activity}/horaires/{horaires}', [ActiviteController::class, 'showhoraire']);
Route::get('activities/{activity}/horaires', [ActiviteController::class, 'indexhoraires']);
Route::delete('activities/{activity}/horaires/{horaires}', [ActiviteController::class, 'detachhoraire']);
Route::post('activities/{activity}/horaires', [ActiviteController::class, 'choosehoraire']);
//horaire
Route::apiResource('horaires',HoraireController::class);

Route::apiResource('offres',offreController::class);
// Define route for attaching activities to an offer
Route::put('/offers/{offerId}/attach-activities', [OffreController::class, 'attachActivities']);

// Define route for detaching activity from offer
Route::put('/offers/{offerId}/detach-activity', [OffreController::class, 'detachActivity']);

});




// ----- en test ----- //
Route::apiResource('devis',deviController::class);