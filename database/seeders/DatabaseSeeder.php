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
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // 3. Création des Chefs de Projet
        $chef1 = User::create([
            'name' => 'Alice Chef',
            'email' => 'chef1@example.com',
            'password' => Hash::make('password'),
            'role_id' => $chefRole->id,
        ]);

        $chef2 = User::create([
            'name' => 'Bob Manager',
            'email' => 'chef2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $chefRole->id,
        ]);

        // 4. Création des Développeurs
        $dev1 = User::create([
            'name' => 'Charlie Dev',
            'email' => 'dev1@example.com',
            'password' => Hash::make('password'),
            'role_id' => $devRole->id,
        ]);

        $dev2 = User::create([
            'name' => 'David Dev',
            'email' => 'dev2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $devRole->id,
        ]);

        $dev3 = User::create([
            'name' => 'Eve Dev',
            'email' => 'dev3@example.com',
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

        // Association des développeurs au projet
        $project1->developers()->attach([$dev1->id, $dev2->id]);

        // 6. Création de Tâches pour ce Projet avec délais et assignations
        Task::create([
            'project_id' => $project1->id,
            'assigned_to' => $dev1->id,
            'title' => 'Création de la base de données',
            'description' => 'Concevoir et exécuter les migrations pour les utilisateurs et produits',
            'status' => 'in_progress',
            'estimated_hours' => 12,
            'deadline' => now()->addDays(5),
        ]);

        Task::create([
            'project_id' => $project1->id,
            'assigned_to' => $dev2->id,
            'title' => 'Mise en place de l\'authentification',
            'description' => 'Configurer les rôles, permissions et interfaces de connexion',
            'status' => 'todo',
            'estimated_hours' => 8,
            'deadline' => now()->addDays(10),
        ]);
    }
}