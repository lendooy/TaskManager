@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Mes Tâches Assignées</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($tasks as $task)
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-600">
            <div class="flex justify-between items-start">
                <h2 class="text-lg font-bold">{{ $task->title }}</h2>
                <span class="text-xs font-semibold px-2 py-1 rounded bg-yellow-100 text-yellow-800">{{ $task->status }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Projet: {{ $task->project->name }}</p>
            <p class="text-sm text-red-600 font-semibold mt-2">Délai: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'Aucun' }}</p>

            <form action="{{ route('dev.tasks.update-status', $task) }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="border p-1 text-sm rounded">
                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>À faire</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Terminée</option>
                </select>
                <button type="submit" class="bg-gray-800 text-white text-sm px-3 py-1 rounded">Mettre à jour</button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">Aucune tâche assignée pour le moment.</p>
    @endforelse
</div>
@endsection