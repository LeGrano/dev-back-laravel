<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\listeController;
use App\Http\Controllers\mdpModifController;
use App\Http\Controllers\teamController;


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
Route::view('/insertion-mdp', 'insertion-mdp')->name('insertion-mdp');
Route::view('/liste-mdp', 'liste-mdp')->name('liste-mdp');
Route::view('/modif-mdp/{id}', 'modif-mdp')->name('modif-mdp');
Route::view('/page-verif', 'page-verif');

//__________TEAM_________________
Route::view('/liste-team', 'liste-team')->name('liste-team');
Route::view('/insertion-team', 'insertion-team')->name('insertion-team');

//____________CONTROLLER_______________
Route::get('/liste', [listeController::class, 'getInfos'])->name('liste');
Route::get('/get', [FormController::class, 'getForm'])->name('form.post');

Route::get('/valid/{id}', [mdpModifController::class, 'modifMdp'])->name('valid-modif-controller');
Route::get('/modif/{id}', [mdpModifController::class, 'formModifMdp'])->name('modif-controller');

Route::get('/team',[teamController::class, 'insertTeam'])->name('insert-team-controller');
Route::get('/liste-team',[teamController::class, 'listeTeam'])->name('liste-team-controller');
Route::get('/join-team/{id}', [TeamController::class, 'joinTeam'])->name('joinTeam');
Route::get('/leave-team/{id}', [TeamController::class, 'leaveTeam'])->name('leaveTeam');

