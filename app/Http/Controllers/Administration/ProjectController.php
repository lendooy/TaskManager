<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Affiche la liste paginée de tous les projets avec le nombre de tâches.
     */
    public function index()
    {
        $projects = Project::withCount('tasks')
            ->latest()
            ->paginate(10);

        return view('administration.projects.index', compact('projects'));
    }

    /**
     * Affiche le formulaire de création d'un projet.
     */
    public function create()
    {
        return view('administration.projects.create');
    }

    /**
     * Valide et enregistre un nouveau projet en base de données.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        // Enregistrement du projet
        Project::create($validated);

        return redirect()->route('administration.projects.index')
            ->with('success', 'Le projet a été créé avec succès.');
    }
}