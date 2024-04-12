<?php

use App\Http\Controllers\API\AbsenceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CongeController;
use App\Http\Controllers\API\DemandeAbsenceController;
use App\Http\Controllers\API\DemandeCongeController;
use App\Http\Controllers\API\EchelleController;
use App\Http\Controllers\API\EtablissementController;
use App\Http\Controllers\API\FonctionController;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\PersonneController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ServiceController;
use App\Models\DemandeConge;
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
Route::group([
    'middleware' => 'api',
    // 'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::middleware('auth:api')->group(function () {
    Route::post('conge/create/{id}', [CongeController::class, 'CreateConge']);
    Route::get('/user-profile', [ProfileController::class, 'getUserProfile']);
});

Route::middleware(['auth', 'role:Directeur,Admin'])->group(function () {
    Route::resource('etablissement', EtablissementController::class);
    Route::get('admin/demande/Conge', [DemandeCongeController::class, 'ListDemandeCongeAdmin']);
    Route::get('admin/demande/Absence', [DemandeAbsenceController::class, 'ListDemandeAbsenceAdmin']);
    Route::post('demande/absence/reject/{id}', [DemandeAbsenceController::class, 'DemandeReject']);
    Route::post('demande/conge/reject/{id}', [DemandeCongeController::class, 'DemandeReject']);
    Route::post('absence/create/{id}', [AbsenceController::class, 'CreateAbsence']);
});
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('echelle', EchelleController::class);
    Route::resource('fonction', FonctionController::class);
    Route::resource('grade', GradeController::class);
});
Route::middleware(['auth', 'role:Employé,Superviseur'])->group(function () {
    Route::resource('demande/Absence', DemandeAbsenceController::class);
    Route::resource('demande/Conge', DemandeCongeController::class);
});
Route::middleware(['auth', 'role:Superviseur,Directeur,Admin'])->group(function () {
    Route::resource('personne', PersonneController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('absence', AbsenceController::class);
    Route::resource('conge', CongeController::class);
});
