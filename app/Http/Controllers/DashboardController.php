<?php

// namespace App\Http\Controllers;

// use App\Models\Project;
// use App\Models\Role;
// use App\Models\Task;
// use App\Models\Timesheet;
// use App\Models\User;
// use Illuminate\Http\Request;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         // Statistiques globales
//         $totalProjects = Project::count();
//         $totalTasks = Task::count();
//         $completedTasks = Task::where('status', 'done')->count();
//         $totalHoursLogged = Timesheet::sum('hours');

//         // Projets récents
//         $recentProjects = Project::withCount('tasks')
//             ->latest()
//             ->take(5)
//             ->get();

//         // Tâches récentes avec Projet, Développeur et son Rôle
//         $recentTasks = Task::with(['project', 'assignee.role'])
//             ->latest()
//             ->take(6)
//             ->get();

//         // Liste des rôles enregistrés
//         $roles = Role::withCount('users')->get();

//         return view('dashboard', compact(
//             'totalProjects',
//             'totalTasks',
//             'completedTasks',
//             'totalHoursLogged',
//             'recentProjects',
//             'recentTasks',
//             'roles'
//         ));
//     }
// }
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirige l'utilisateur vers son espace selon son rôle.
     */
    public function __invoke(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isChefDeProjet()) {
            return redirect()->route('chef.projects.index');
        }

        return redirect()->route('dev.tasks.index');
    }
}