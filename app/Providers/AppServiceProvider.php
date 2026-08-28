<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistrement des services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialisation des services de l'application.
     */
    public function boot(): void
    {
        // Définition des règles d'accès basées sur les méthodes du modèle User
        Gate::define('isAdmin', fn (User $user) => $user->isAdmin());
        Gate::define('isChefDeProjet', fn (User $user) => $user->isChefDeProjet());
        Gate::define('isDeveloppeur', fn (User $user) => $user->isDeveloppeur());
    }
}