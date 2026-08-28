@extends('layouts.administration')

@section('title', 'Modifier la Tâche - TaskManager IT')
@section('page_title', 'Gestion des Tâches')
@section('page_subtitle', 'Édition de la tâche #' . $task->id)

@section('page_actions')
    <a href="{{ route('administration.tasks.index') }}" class="text-xs font-semibold text-slate-700 hover:text-slate-900 transition flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-300 bg-white shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Retour</span>
    </a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex items-center justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Modifier la Tâche</h2>
            <span class="text-[10px] font-mono px-2 py-0.5 bg-slate-200/70 border border-slate-300 rounded font-semibold text-slate-700">
                #{{ $task->id }}
            </span>
        </div>

        <form action="{{ route('administration.tasks.update', $task) }}" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <!-- Titre de la tâche -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Titre de la tâche <span class="text-emerald-600">*</span></label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}" required placeholder="Ex: Implémenter le système d'authentification" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">
                @error('title')
                    <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Projet associé -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Projet <span class="text-emerald-600">*</span></label>
                    <select name="project_id" required class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">
                        <option value="">-- Sélectionner un projet --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Membre assigné (assigned_to) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigné à</label>
                    <select name="assigned_to" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">
                        <option value="">-- Non assignée --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} {{ $user->role ? '(' . $user->role->name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Statut -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Statut <span class="text-emerald-600">*</span></label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">
                        <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>À faire (Todo)</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>En cours (In Progress)</option>
                        <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Terminée (Done)</option>
                    </select>
                    @error('status')
                        <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimation d'heures -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Temps estimé (heures)</label>
                    <input type="number" step="0.5" min="0" name="estimated_hours" value="{{ old('estimated_hours', $task->estimated_hours) }}" placeholder="Ex: 8" class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">
                    @error('estimated_hours')
                        <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Description / Consignes</label>
                <textarea name="description" rows="3" placeholder="Détails complémentaires de la tâche..." class="w-full bg-slate-50 border border-slate-300 rounded px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-[10px] text-red-600 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-3 border-t border-slate-200/80 flex items-center justify-end gap-2.5">
                <a href="{{ route('administration.tasks.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-1.5 rounded-md shadow-sm transition flex items-center gap-1.5">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                    <span>Mettre à jour</span>
                </button>
            </div>
        </form>
    </div>
@endsection