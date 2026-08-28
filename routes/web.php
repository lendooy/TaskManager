<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChefDeProjet\ProjectController;
use App\Http\Controllers\ChefDeProjet\TaskController as ChefTaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Developpeur\TaskController as DevTaskController;
use App\Http\Controllers\Developpeur\TimesheetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques & Authentification
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Routes Protégées (Authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Redirection automatique centralisée via le contrôleur invokable
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Espace Administrateur (Gestion des utilisateurs et statistiques)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:isAdmin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Espace Chef de Projet (Projets, équipes & tâches)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:isChefDeProjet'])->prefix('chef')->name('chef.')->group(function () {
        // CRUD des projets
        Route::resource('projects', ProjectController::class);

        // Affectation/désaffectation des développeurs sur un projet
        Route::post('projects/{project}/assign-developer', [ProjectController::class, 'assignDeveloper'])
            ->name('projects.assign-developer');
        Route::delete('projects/{project}/remove-developer/{user}', [ProjectController::class, 'removeDeveloper'])
            ->name('projects.remove-developer');

        // Création et attribution des tâches avec délai
        Route::resource('projects.tasks', ChefTaskController::class)->except(['index']);
    });

    /*
    |--------------------------------------------------------------------------
    | Espace Développeur (Tâches & Timesheets)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:isDeveloppeur'])->prefix('dev')->name('dev.')->group(function () {
        // Consultation et modification du statut des tâches
        Route::get('tasks', [DevTaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/{task}', [DevTaskController::class, 'show'])->name('tasks.show');
        Route::patch('tasks/{task}/status', [DevTaskController::class, 'updateStatus'])->name('tasks.update-status');

        // Saisie et suivi des heures
        Route::post('tasks/{task}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
        Route::resource('timesheets', TimesheetController::class)->only(['index', 'destroy']);
    });

});