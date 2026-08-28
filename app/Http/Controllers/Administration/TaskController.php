<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Affiche la liste des tâches avec filtres par projet et assignation.
     */
    public function index()
    {
        $tasks = Task::with(['project', 'assignee'])
            ->latest()
            ->paginate(15);

        return view('administration.tasks.index', compact('tasks'));
    }

    /**
     * Affiche le formulaire de création d'une tâche.
     */
    public function create()
    {
        // Chargement des projets et des utilisateurs pour alimenter les listes déroulantes
        $projects = Project::all();
        $users = User::with('role')->get();

        return view('administration.tasks.create', compact('projects', 'users'));
    }

    /**
     * Valide et enregistre une nouvelle tâche.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'estimated_hours' => 'nullable|numeric|min:0',
        ]);

        Task::create($validated);

        return redirect()->route('administration.tasks.index')
            ->with('success', 'La tâche a été créée et assignée avec succès.');
    }
    /**
     * Affiche le formulaire d'édition d'une tâche.
     */
    public function edit(Task $task)
    {
        $projects = Project::orderBy('name')->get();
        $users = User::with('role')->orderBy('name')->get();

        return view('administration.tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Valide et met à jour la tâche.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id'      => 'required|exists:projects,id',
            'assigned_to'      => 'nullable|exists:users,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'status'          => 'required|in:todo,in_progress,done',
            'estimated_hours' => 'nullable|numeric|min:0',
        ]);

        $task->update($validated);

        return redirect()->route('administration.tasks.index')
            ->with('success', 'La tâche a été mise à jour avec succès.');
    }
}