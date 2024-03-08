<?php

use App\Http\Controllers\API\AbsenceController;
use App\Http\Controllers\API\CongeController;
use App\Http\Controllers\API\DemandeController;
use App\Http\Controllers\API\EchelleController;
use App\Http\Controllers\API\EtablissementController;
use App\Http\Controllers\API\FonctionController;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\PersonneController;
use App\Http\Controllers\API\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('personne', PersonneController::class);
Route::resource('absence', AbsenceController::class);
Route::resource('conge', CongeController::class);
Route::resource('demande', DemandeController::class);
Route::resource('echelle', EchelleController::class);
Route::resource('etablissement', EtablissementController::class);
Route::resource('fonction', FonctionController::class);
Route::resource('grade', GradeController::class);
Route::resource('service', ServiceController::class);
