<?php

namespace Database\Seeders; // <-- Utilisez Database\Seeders au lieu de DatabaseSeeders
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Exécuter les seeders de la base de données.
     */
    public function run(): void
    {
        // 1. Création des Rôles
        $adminRole = Role::create([
            'name' => 'Admin',
            'description' => 'Administrateur système avec accès complet',
        ]);

        $chefRole = Role::create([
            'name' => 'Chef de projet',
            'description' => 'Gestionnaire de projets, affectation d\'équipes et de tâches',
        ]);

        $devRole = Role::create([
            'name' => 'Développeur',
            'description' => 'Exécuteur de tâches et saisie des temps de travail',
        ]);

        // 2. Création de l'Administrateur
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // 3. Création des Chefs de Projet
        $chef1 = User::create([
            'name' => 'ibrahim',
            'email' => 'ibrahim@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $chefRole->id,
        ]);

        

        // 4. Création des Développeurs
        $dev1 = User::create([
            'name' => 'ali',
            'email' => 'ali@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $devRole->id,
        ]);

         

        // 5. Création d'un Projet de test géré par Alice
        $project1 = Project::create([
            'name' => 'Plateforme E-Commerce',
            'description' => 'Développement du site e-commerce et de l\'API de paiement',
            'status' => 'in_progress',
            'deadline' => now()->addDays(30),
            'created_by' => $chef1->id,
        ]);

    }
}