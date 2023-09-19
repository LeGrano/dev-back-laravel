<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
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

Route::view('/insertion-mdp', 'insertion-mdp')->name('insertion-mdp');
Route::view('/page-verif', 'page-verif');


Route::get('/get', [FormController::class, 'getForm'])->name('form.post');