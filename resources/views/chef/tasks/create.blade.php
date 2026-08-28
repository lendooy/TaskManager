@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Créer une Tâche pour {{ $project->name }}</h2>
    <form action="{{ route('chef.projects.tasks.store', $project) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Titre de la tâche</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Attribuer au Développeur</label>
            <select name="assigned_to" class="w-full border p-2 rounded" required>
                @foreach($project->developers as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Délai (Date limite)</label>
            <input type="date" name="deadline" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded w-full">Attribuer la tâche</button>
    </form>
</div>
@endsection