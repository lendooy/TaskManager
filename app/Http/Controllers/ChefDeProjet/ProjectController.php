<?php

namespace App\Http\Controllers\ChefDeProjet;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('created_by', auth()->id())
            ->with(['developers', 'tasks'])
            ->latest()
            ->paginate(10);

        return view('chef.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('chef.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline' => ['nullable', 'date'],
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'created_by' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('chef.projects.index')->with('success', 'Projet créé avec succès.');
    }

    public function show(Project $project)
    {
        $this->authorizeProject($project);

        // Utilisation de assignedTo au lieu de assignee
        $project->load(['developers', 'tasks.assignedTo']);
        
        // Récupération des développeurs non encore affectés à ce projet
        $availableDevelopers = User::where(function ($query) {
                $query->whereHas('role', fn($q) => $q->where('name', 'Développeur')
                                                   ->orWhere('name', 'developpeur'))
                      ->orWhere('role_id', 3); // Support si vous utilisez un role_id fixe
            })
            ->whereNotIn('id', $project->developers->pluck('id'))
            ->get();

        return view('chef.projects.show', compact('project', 'availableDevelopers'));
    }

    public function assignDeveloper(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $project->developers()->syncWithoutDetaching([$request->user_id]);

        return back()->with('success', 'Développeur assigné au projet avec succès.');
    }

    public function removeDeveloper(Project $project, User $user)
    {
        $this->authorizeProject($project);

        $project->developers()->detach($user->id);

        return back()->with('success', 'Développeur retiré du projet.');
    }

    private function authorizeProject(Project $project)
    {
        if ($project->created_by !== auth()->id()) {
            abort(403, 'Action non autorisée sur ce projet.');
        }
    }
}