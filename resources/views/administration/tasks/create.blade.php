@extends('layouts.administration')

@section('title', 'Nouvelle Tâche - ProjEct IT')
@section('page_title', 'Tâches')
@section('page_subtitle', 'Nouvelle tâche')

@section('page_actions')
    <a href="{{ route('administration.tasks.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-200 bg-white shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5 stroke-[2]"></i>
        <span>Retour</span>
    </a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Créer et assigner une tâche</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Associez la tâche à un projet et définissez le développeur en charge.</p>
        </div>

        <form action="{{ route('administration.tasks.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Sélection du Projet -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Projet Rattaché <span class="text-emerald-600">*</span></label>
                <select name="project_id" required class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    <option value="">-- Choisir un projet --</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id') <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Intitulé de la tâche -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Titre de la Tâche <span class="text-emerald-600">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ex: Corriger le bug d'authentification SSL" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                @error('title') <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Assignation à un Développeur -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Assigner à</label>
                <select name="assigned_to" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    <option value="">-- Non assigné --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} {{ isset($user->role) ? '('.$user->role->name.')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Explications et spécifications techniques de la tâche..." class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">{{ old('description') }}</textarea>
            </div>

            <!-- Statut et Estimation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Statut <span class="text-emerald-600">*</span></label>
                    <select name="status" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                        <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>À faire</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Temps estimé (heures)</label>
                    <input type="number" step="0.5" name="estimated_hours" value="{{ old('estimated_hours') }}" placeholder="Ex: 4.5" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('administration.tasks.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                    <span>Enregistrer la tâche</span>
                </button>
            </div>
        </form>
    </div>
@endsection