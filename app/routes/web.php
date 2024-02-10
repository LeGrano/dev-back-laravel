<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Other\routesController;
use App\Http\Controllers\password\FormController;
use App\Http\Controllers\Other\listeController;
use App\Http\Controllers\password\mdpModifController;
use App\Http\Controllers\team\teamController;
use App\Models\Team;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//__________MDP_________________

Route::get('/insertion-mdp', [routesController::class, 'insertionMDP'])->name('insertion-mdp');
Route::get('/liste-mdp', [routesController::class, 'listeMDP'])->name('liste-mdp');
Route::get('/modif-mdp/{id}', [routesController::class, 'formModifMdp'])->name('modif-mdp');
Route::get('/page-verif', [routesController::class, 'verifMdp'])->name('verif-mdp');

//__________TEAM_________________
Route::get('/liste-team', [routesController::class, 'listeTeam'])->name('liste-team');
Route::get('/insertion-team', [routesController::class, 'insertionTeam'])->name('insertion-team');
Route::get('/team-manager', [routesController::class, 'manageTeam'])->name('team-manager');


Route::get('/liste', [listeController::class, 'getInfos'])->name('liste');
Route::get('/get', [FormController::class, 'getForm'])->name('form.post');

Route::get('/valid/{id}', [mdpModifController::class, 'modifMdp'])->name('valid-modif-controller');
Route::get('/modif/{id}', [mdpModifController::class, 'formModifMdp'])->name('modif-controller');

Route::get('/team',[teamController::class, 'insertTeam'])->name('insert-team-controller');
Route::get('/liste-team',[teamController::class, 'listeTeam'])->name('liste-team-controller');
Route::get('/join-team/{id}', [TeamController::class, 'joinTeam'])->name('joinTeam');
Route::get('/leave-team/{id}', [TeamController::class, 'leaveTeam'])->name('leaveTeam');
Route::get('/manage-team/{id}', [teamController::class, 'goToManageTeam'])->name('manage-team');
Route::get('/add-team-password', [teamController::class, 'addTeamPassword'])->name('add-team-password');
Route::get('/add-users',[teamController::class, 'addUsers'])->name('addUsers');
