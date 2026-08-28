@extends('layouts.administration')

@section('title', 'Déclarer du temps - ProjEct IT')
@section('page_title', 'Saisies de temps')
@section('page_subtitle', 'Enregistrer des heures de travail')

@section('page_actions')
    <a href="{{ route('administration.timesheets.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-200 bg-white shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5 stroke-[2]"></i>
        <span>Retour</span>
    </a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Nouvelle saisie de temps</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Renseignez les détails du temps passé sur une tâche.</p>
        </div>

        <form action="{{ route('administration.timesheets.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Sélection de la Tâche -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tâche concernée <span class="text-emerald-600">*</span></label>
                <select name="task_id" required class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    <option value="">-- Sélectionnez une tâche --</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                            {{ $task->title }} @if(isset($task->project)) (Projet: {{ $task->project->name }}) @endif
                        </option>
                    @endforeach
                </select>
                @error('task_id') 
                    <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Sélection du Membre -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Membre de l'équipe</label>
                <select name="user_id" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    <option value="">Utilisateur connecté (Moi)</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') 
                    <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Heures passées (hours) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Durée (heures) <span class="text-emerald-600">*</span></label>
                    <input type="number" step="0.25" min="0.25" max="24" name="hours" value="{{ old('hours', '1.00') }}" required placeholder="Ex: 2.5" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    @error('hours') 
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Date d'enregistrement (logged_at) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Date <span class="text-emerald-600">*</span></label>
                    <input type="date" name="logged_at" value="{{ old('logged_at', date('Y-m-d')) }}" required class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                    @error('logged_at') 
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Note / Description (note) -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Note / Remarque</label>
                <textarea name="note" rows="3" placeholder="Détails du travail effectué durant cette session..." class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">{{ old('note') }}</textarea>
                @error('note') 
                    <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('administration.timesheets.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                    <span>Enregistrer</span>
                </button>
            </div>
        </form>
    </div>
@endsection