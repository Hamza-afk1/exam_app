<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\ExamenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('formateurs', FormateurController::class);
Route::get('/formateur', [FormateurController::class, 'index'])->name('formateur.index');


Route::prefix('examens')->group(function () {
    Route::get('/', [ExamenController::class, 'index'])->name('examens.index'); // Liste des examens
    Route::get('/create', [ExamenController::class, 'create'])->name('examens.create'); // Formulaire de création
    Route::post('/store', [ExamenController::class, 'store'])->name('examens.store'); // Enregistrer un nouvel examen
    Route::get('/{id}/manage', [ExamenController::class, 'manage'])->name('examens.manage'); // Gestion de l'examen
});

Route::delete('/examens/{id}', [ExamenController::class, 'destroy'])->name('examens.delete');
Route::post('/examens/update-question', [ExamenController::class, 'updateQuestion'])->name('examens.updateQuestion');
Route::post('/examens/{examen}/add-question', [ExamenController::class, 'addQuestion'])->name('examens.addQuestion');



Route::resource('examens', ExamenController::class);
Route::get('/examens', [ExamenController::class, 'index'])->name('examens.index');



Route::get('/examens/{id}/manage', [ExamenController::class, 'manage'])->name('examens.manage');
Route::post('/examens/update', [ExamenController::class, 'update'])->name('examens.update');
Route::delete('/examens/{id}/delete', [ExamenController::class, 'deleteQuestion'])->name('examens.deleteQuestion');
Route::post('/examens/add-question', [ExamenController::class, 'addQuestion'])->name('examens.addQuestion');




Route::resource('stagiaire', StagiaireController::class);
Route::get('/stagiaire', [StagiaireController::class, 'index'])->name('stagiaire.index');

Route::get('/admin/register', [AdminController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');


Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');

Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

Route::get('/admin/user', [AdminController::class, 'showUserList'])->name('admin.user');
Route::post('/users', [AdminController::class, 'store'])->name('users.store');

Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');