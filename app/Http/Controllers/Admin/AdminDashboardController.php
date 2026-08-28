<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users'     => User::count(),
            'total_projects'  => Project::count(),
            'total_tasks'     => Task::count(),
            'total_hours'     => Timesheet::sum('hours'),
        ];

        // Récupération des données récentes pour les tables d'aperçu
        $recentUsers = User::with('role')->latest()->take(5)->get();
        $recentProjects = Project::with('chef')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects'));
    }
}