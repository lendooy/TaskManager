<?php

namespace App\Http\Controllers\ChefDeProjet;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(Project $project): View
    {
        $project->load('developers');
        return view('chef.tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'assigned_to'     => ['nullable', 'exists:users,id'],
            'estimated_hours' => ['required', 'numeric', 'min:0.5', 'max:500'],
            'deadline'        => ['required', 'date'],
        ]);

        $project->tasks()->create([
            'title'           => $validated['title'],
            'description'     => $validated['description'],
            'assigned_to'     => $validated['assigned_to'] ?? null,
            'estimated_hours' => $validated['estimated_hours'],
            'deadline'        => $validated['deadline'],
            'status'          => 'todo',
        ]);

        return redirect()->route('chef.projects.show', $project)
            ->with('success', 'Tâche créée avec succès.');
    }
}