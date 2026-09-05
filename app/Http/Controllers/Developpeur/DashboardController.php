<?php

namespace App\Http\Controllers\Developpeur;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        // 1. Projets assignés au développeur
        $projects = Project::whereHas('developers', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })
        ->withCount(['tasks as total_tasks' => function ($query) use ($userId) {
            $query->where('assigned_to', $userId)->orWhereNull('assigned_to');
        }])
        ->latest()
        ->get();

        // 2. Statistiques des tâches (assignées + disponibles dans ses projets)
        $tasksQuery = Task::where(function ($query) use ($userId) {
            $query->where('assigned_to', $userId)
                ->orWhere(function ($q) use ($userId) {
                    $q->whereNull('assigned_to')
                      ->whereHas('project.developers', function ($devQuery) use ($userId) {
                          $devQuery->where('users.id', $userId);
                      });
                });
        });

        $stats = [
            'total_tasks'       => (clone $tasksQuery)->count(),
            'todo_tasks'        => (clone $tasksQuery)->where('status', 'todo')->count(),
            'in_progress_tasks' => (clone $tasksQuery)->whereIn('status', ['in_progress', 'en_cours'])->count(),
            'completed_tasks'   => (clone $tasksQuery)->whereIn('status', ['completed', 'terminé'])->count(),
            'total_hours'       => Timesheet::where('user_id', $userId)->sum('hours'),
        ];

        // 3. Dernières tâches récentes
        $recentTasks = (clone $tasksQuery)->with('project')->latest()->take(5)->get();

        return view('dev.dashboard', compact('projects', 'stats', 'recentTasks'));
    }
}