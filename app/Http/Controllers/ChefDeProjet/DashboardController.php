<?php

namespace App\Http\Controllers\ChefDeProjet; // Assurez-vous d'avoir ChefDeProjet ici

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $totalHours = Timesheet::sum('hours');

        $stats = [
            'total_projects'  => $totalProjects,
            'total_tasks'     => $totalTasks,
            'completed_tasks' => $completedTasks,
            'total_hours'     => $totalHours,
        ];

        $projects = Project::withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
            $query->where('status', 'completed');
        }])->latest()->take(5)->get();

        $recentTasks = Task::with(['project', 'assignedTo'])->latest()->take(5)->get();

        return view('chef.dashboard', compact('stats', 'projects', 'recentTasks'));
    }
}