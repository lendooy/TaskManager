@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">{{ $project->name }}</h1>
    <p class="text-gray-600 mt-2">{{ $project->description }}</p>
    <p class="text-sm text-gray-500 mt-1">Délai du projet: <strong>{{ $project->deadline ? $project->deadline->format('d/m/Y') : 'Non défini' }}</strong></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Équipe de Développeurs -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Développeurs assignés</h2>
        <ul class="divide-y divide-gray-200 mb-4">
            @forelse($project->developers as $dev)
                <li class="py-2 flex justify-between items-center">
                    <span>{{ $dev->name }} ({{ $dev->email }})</span>
                    <form action="{{ route('chef.projects.remove-developer', [$project, $dev]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 text-sm">Retirer</button>
                    </form>
                </li>
            @empty
                <li class="text-gray-500 py-2">Aucun développeur sur ce projet.</li>
            @endforelse
        </ul>

        <form action="{{ route('chef.projects.assign-developer', $project) }}" method="POST" class="flex gap-2">
            @csrf
            <select name="user_id" class="border p-2 rounded flex-1" required>
                <option value="">Sélectionner un développeur...</option>
                @foreach($availableDevelopers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Ajouter</button>
        </form>
    </div>

    <!-- Tâches du Projet -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Tâches du projet</h2>
            <a href="{{ route('chef.projects.tasks.create', $project) }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm">+ Nouvelle Tâche</a>
        </div>
        <ul class="divide-y divide-gray-200">
            @forelse($project->tasks as $task)
                <li class="py-3">
                    <div class="flex justify-between">
                        <span class="font-bold">{{ $task->title }}</span>
                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ $task->status }}</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        Assignée à: {{ $task->assignee->name ?? 'Unassigned' }} | Délai: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'N/A' }}
                    </div>
                </li>
            @empty
                <li class="text-gray-500 py-2">Aucune tâche créée.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection