@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mes Projets</h1>
    <a href="{{ route('chef.projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
        + Nouveau Projet
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
        <div class="bg-white p-6 rounded-lg shadow border-t-4 border-indigo-600 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-xl font-bold text-gray-900">{{ $project->name }}</h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-blue-100 text-blue-800">
                        {{ $project->status }}
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                <div class="text-xs text-gray-500 space-y-1">
                    <p>Développeurs : <strong>{{ $project->developers->count() }}</strong></p>
                    <p>Tâches : <strong>{{ $project->tasks->count() }}</strong></p>
                    <p>Délai : <strong>{{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : 'Non défini' }}</strong></p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('chef.projects.show', $project) }}" class="block text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold py-2 rounded transition">
                    Gérer le projet
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-8 text-gray-500">
            Aucun projet créé pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $projects->links() }}</div>
@endsection