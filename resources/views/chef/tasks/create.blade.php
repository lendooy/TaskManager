@extends('layouts.app')

@section('title', 'Nouvelle Tâche')
@section('page_title', 'Gestion des Tâches')
@section('page_subtitle', 'Projet : ' . $project->name)

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm p-6">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
        <h2 class="text-base font-bold text-slate-900">Créer une nouvelle tâche</h2>
        <a href="{{ route('chef.projects.show', $project) }}" class="text-xs font-medium text-slate-500 hover:text-slate-800 flex items-center gap-1 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour au projet
        </a>
    </div>

    <form action="{{ route('chef.projects.tasks.store', $project) }}" method="POST" class="space-y-5">
        @csrf

        <!-- Titre de la tâche -->
        <div>
            <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Titre de la tâche <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                placeholder="Ex: Intégration de la maquette"
                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Développeur assigné -->
        <div>
            <label for="assigned_to" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Attribuer à un développeur
            </label>

            @if($project->developers->isEmpty())
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-md text-xs text-amber-700">
                    Aucun développeur n'est encore affecté à ce projet.
                </div>
            @elseif($project->developers->count() === 1)
                @php $singleDev = $project->developers->first(); @endphp
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-md flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-800">{{ $singleDev->name }}</p>
                        <p class="text-[11px] text-slate-500">{{ $singleDev->email }}</p>
                    </div>
                    <span class="text-[10px] bg-indigo-50 text-indigo-700 font-semibold px-2 py-0.5 rounded border border-indigo-200">
                        Seul développeur du projet
                    </span>
                    <input type="hidden" name="assigned_to" value="{{ $singleDev->id }}">
                </div>
            @else
                <select name="assigned_to" id="assigned_to"
                    class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('assigned_to') border-red-500 @enderror">
                    <option value="">-- Non assignée (Disponible pour l'équipe du projet) --</option>
                    @foreach($project->developers as $developer)
                        <option value="{{ $developer->id }}" {{ old('assigned_to') == $developer->id ? 'selected' : '' }}>
                            {{ $developer->name }} ({{ $developer->email }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1">Laissez vide si vous souhaitez qu'aucun développeur particulier ne soit attribué à la création.</p>
            @endif
            
            @error('assigned_to')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Durée estimée en heures -->
            <div>
                <label for="estimated_hours" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Durée estimée (en heures) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" step="0.5" min="0.5" name="estimated_hours" id="estimated_hours" 
                        value="{{ old('estimated_hours', '1') }}" required
                        placeholder="Ex: 4 ou 2.5"
                        class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('estimated_hours') border-red-500 @enderror">
                    <span class="absolute right-3 top-2 text-xs text-slate-400 font-medium">heures</span>
                </div>
                @error('estimated_hours')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date limite -->
            <div>
                <label for="deadline" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Date limite <span class="text-red-500">*</span>
                </label>
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                    class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('deadline') border-red-500 @enderror">
                @error('deadline')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Description / Spécifications
            </label>
            <textarea name="description" id="description" rows="4"
                placeholder="Détails techniques, livrables..."
                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('chef.projects.show', $project) }}"
                class="px-4 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                Annuler
            </a>
            <button type="submit"
                class="px-4 py-2 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Enregistrer la tâche
            </button>
        </div>
    </form>
</div>
@endsection