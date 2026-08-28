<?php

namespace App\Http\Controllers\ChefDeProjet;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        $project->load('developers');
        return view('chef.tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['required', 'exists:users,id'],
            'estimated_hours' => ['nullable', 'integer', 'min:1'],
            'deadline' => ['required', 'date'],
        ]);

        $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'estimated_hours' => $request->estimated_hours,
            'deadline' => $request->deadline,
            'status' => 'todo',
        ]);

        return redirect()->route('chef.projects.show', $project)->with('success', 'Tâche créée et attribuée avec succès.');
    }
}