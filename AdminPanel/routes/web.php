<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CoursController; 
use App\Http\Controllers\GroupeController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;



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
Route::resource('users', UserController::class);


// Admin routes
Route::middleware(['auth:admin', 'checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Other admin routes...
});

// Formateur routes
Route::middleware(['formateur.auth'])->group(function () {
    Route::get('/formateur/dashboard', [FormateurController::class, 'dashboard'])
         ->name('formateur.dashboard');
    Route::get('/formateur/debug', function() {
        $formateur = Auth::guard('formateur')->user();
        dd([
            'formateur' => $formateur,
            'groups' => $formateur->groupes()->get(),
            'courses' => $formateur->cours()->get(),
            'auth_check' => Auth::guard('formateur')->check()
        ]);
    });
    // ... other formateur routes ...
});
   

    Route::middleware(['web'])->group(function () {
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

Route::middleware(['auth:admin,formateur'])->group(function () {
     // Dashboard
     Route::get('/dashboard', [FormateurController::class, 'dashboard'])->name('formateur.dashboard');
        
     // Profile
     Route::get('/profile', [FormateurController::class, 'profile'])->name('formateur.profile');
     Route::put('/profile/update', [FormateurController::class, 'updateProfile'])->name('formateur.profile.update');
     
  // Logout
  Route::post('/logout', [FormateurController::class, 'logout'])->name('formateur.logout');
  
    // Cours routes
    Route::get('/cours', [CoursController::class, 'index'])->name('cours.index');
    Route::post('/cours', [CoursController::class, 'store'])->name('cours.store');
    Route::get('/cours/create', [CoursController::class, 'create'])->name('cours.create');
    Route::put('/cours/{cours}', [CoursController::class, 'update'])->name('cours.update');
    Route::delete('/cours/{cours}', [CoursController::class, 'destroy'])->name('cours.destroy');

    // Groupes routes
    Route::get('/groupes', [GroupeController::class, 'index'])->name('groupes.index');
    Route::post('/groupes', [GroupeController::class, 'store'])->name('groupes.store');
    Route::get('/groupes/create', [GroupeController::class, 'create'])->name('groupes.create');
    Route::put('/groupes/{groupe}', [GroupeController::class, 'update'])->name('groupes.update');
    Route::delete('/groupes/{groupe}', [GroupeController::class, 'destroy'])->name('groupes.destroy');

    // Examens routes
    Route::get('/examens', [ExamenController::class, 'index'])->name('examens.index');
    Route::post('/examens', [ExamenController::class, 'store'])->name('examens.store');
    Route::get('/examens/create', [ExamenController::class, 'create'])->name('examens.create');
    Route::get('/examens/{examen}/edit', [ExamenController::class, 'edit'])->name('examens.edit');
    Route::put('/examens/{examen}', [ExamenController::class, 'update'])->name('examens.update');
    Route::delete('/examens/{examen}', [ExamenController::class, 'destroy'])->name('examens.destroy');
    Route::get('/examens/corrections', [ExamenController::class, 'corrections'])->name('examens.corrections.list');

    // Stagiaires routes
    Route::get('/stagiaires', [StagiaireController::class, 'index'])->name('stagiaire.index');
    Route::post('/stagiaires', [StagiaireController::class, 'store'])->name('stagiaire.store');
    Route::get('/stagiaires/create', [StagiaireController::class, 'create'])->name('stagiaire.create');
    Route::put('/stagiaires/{stagiaire}', [StagiaireController::class, 'update'])->name('stagiaire.update');
    Route::delete('/stagiaires/{stagiaire}', [StagiaireController::class, 'destroy'])->name('stagiaire.destroy');
});

// Stagiaire routes
Route::middleware(['auth:stagiaire', 'checkRole:stagiaire'])->prefix('stagiaire')->group(function () {
    Route::get('/dashboard', [StagiaireController::class, 'dashboard'])->name('stagiaire.dashboard');
    // Other stagiaire routes...
});
Route::middleware(['auth:stagiaire', 'checkRole:stagiaire'])->group(function () {
    Route::prefix('stagiaire')->group(function () {
        Route::get('/dashboard', [StagiaireController::class, 'dashboard'])->name('stagiaire.dashboard');
        Route::get('/profile', [StagiaireController::class, 'profile'])->name('stagiaire.profile');
        Route::get('/examens', [StagiaireController::class, 'examens'])->name('stagiaire.examens');
        Route::get('/cours', [StagiaireController::class, 'cours'])->name('stagiaire.cours');
        // Add all other stagiaire submenu routes here
    });
});
// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');



Route::resource('groupes', GroupeController::class);
Route::resource('stagiaires', StagiaireController::class);


Route::resource('cours', CoursController::class);
Route::resource('examens', ExamenController::class);

Route::get('examens/{id}/manage', [ExamenController::class, 'manage'])->name('examens.manage');
Route::post('examens/questions', [ExamenController::class, 'addQuestion'])->name('examens.addQuestion');
Route::put('examens/questions', [ExamenController::class, 'updateQuestion'])->name('examens.updateQuestion');
Route::delete('examens/questions/{id}', [ExamenController::class, 'deleteQuestion'])->name('examens.deleteQuestion');

Route::resource('formateurs', FormateurController::class);
Route::get('/formateur', [FormateurController::class, 'index'])->name('formateur.index');

// routes/web.php
// Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/charts', [DashboardController::class, 'charts'])->name('charts');

Route::prefix('examens')->group(function () {
    Route::get('/', [ExamenController::class, 'index'])->name('examens.index'); // Liste des examens
    Route::get('/create', [ExamenController::class, 'create'])->name('examens.create'); // Formulaire de création
    Route::post('/store', [ExamenController::class, 'store'])->name('examens.store'); // Enregistrer un nouvel examen
    Route::get('/{id}/manage', [ExamenController::class, 'manage'])->name('examens.manage'); // Gestion de l'examen
});

Route::delete('/examens/{id}', [ExamenController::class, 'destroy'])->name('examens.delete');
Route::put('/examens/update-question', [ExamenController::class, 'updateQuestion'])->name('examens.updateQuestion');
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

Route::get('/examens/{id}/correction', [ExamenController::class, 'correction'])->name('examens.correction');
Route::post('/questions/{id}/correct', [ExamenController::class, 'correctQuestion'])->name('examens.correctQuestion');

 // Nouvelle route pour la liste des corrections
 Route::get('/corrections', [ExamenController::class, 'correctionsList'])->name('examens.corrections.list');
 Route::get('/examens/{id}/correction', [ExamenController::class, 'correction'])->name('examens.correction');