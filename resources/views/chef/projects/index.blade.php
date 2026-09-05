@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mes Projets</h1>
    <a href="{{ route('chef.projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
        + Nouveau Projet
    </a>
</div>

<div class="space-y-4">
    @forelse($projects as $project)
        <div class="bg-white p-5 rounded-lg shadow border border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="md:w-5/12">
                <div class="flex items-center gap-3 mb-1">
                    <h2 class="text-lg font-bold text-gray-900">{{ $project->name }}</h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-blue-100 text-blue-800 whitespace-nowrap">
                        {{ $project->status }}
                    </span>
                </div>
                <p class="text-gray-600 text-sm">{{ Str::limit($project->description, 120) }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-6 text-xs text-gray-600 md:w-4/12">
                <div>
                    <span class="block text-gray-400">Développeurs</span>
                    <strong class="text-sm text-gray-800">{{ $project->developers->count() }}</strong>
                </div>
                <div>
                    <span class="block text-gray-400">Tâches</span>
                    <strong class="text-sm text-gray-800">{{ $project->tasks->count() }}</strong>
                </div>
                <div>
                    <span class="block text-gray-400">Délai</span>
                    <strong class="text-sm text-gray-800">
                        {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : 'Non défini' }}
                    </strong>
                </div>
            </div>

            <div class="md:w-2/12 text-right">
                <a href="{{ route('chef.projects.show', $project) }}" class="inline-block w-full md:w-auto text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold px-4 py-2 rounded transition text-sm">
                    Gérer le projet
                </a>
            </div>

        </div>
    @empty
        <div class="bg-white rounded-lg shadow border border-gray-200 text-center py-8 text-gray-500">
            Aucun projet créé pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $projects->links() }}</div>
@endsection