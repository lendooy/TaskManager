@extends('layouts.app')

@section('title', 'Détails de la tâche')
@section('page_title', 'Espace Développeur')
@section('page_subtitle', $task->title)

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Bouton retour -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dev.tasks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-slate-800 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour à mes tâches
        </a>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-lg font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Colonne Principale -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Fiche Tâche -->
            <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex items-start justify-between gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 mb-2">
                            Projet : {{ $task->project->name ?? 'N/A' }}
                        </span>
                        <h1 class="text-lg font-bold text-slate-900">{{ $task->title }}</h1>
                    </div>

                    <!-- Statut -->
                    <div>
                        @switch($task->status)
                            @case('completed')
                            @case('terminé')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Terminée
                                </span>
                                @break
                            @case('in_progress')
                            @case('en_cours')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    En cours
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    À faire
                                </span>
                        @endswitch
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description / Spécifications</h3>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-md text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $task->description ?: 'Aucune description fournie pour cette tâche.' }}
                    </div>
                </div>

                <!-- Métadonnées -->
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-3 bg-slate-50/50 rounded-lg border border-slate-200/60">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase">Durée estimée</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $task->estimated_hours ?? 0 }} heures</p>
                    </div>
                    <div class="p-3 bg-slate-50/50 rounded-lg border border-slate-200/60">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase">Date limite</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5">
                            {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'Non définie' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Historique des Temps enregistrés -->
            <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Heures enregistrées</h3>

                @if($task->timesheets && $task->timesheets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-semibold text-slate-400 uppercase border-b border-slate-100">
                                    <th class="pb-2">Date</th>
                                    <th class="pb-2">Développeur</th>
                                    <th class="pb-2">Heures</th>
                                    <th class="pb-2">Note</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($task->timesheets as $timesheet)
                                    <tr>
                                        <td class="py-2.5 text-slate-600">
                                            {{ \Carbon\Carbon::parse($timesheet->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-2.5 font-medium text-slate-800">
                                            {{ $timesheet->user->name ?? 'Dev' }}
                                        </td>
                                        <td class="py-2.5 font-bold text-slate-900">
                                            {{ $timesheet->hours }} h
                                        </td>
                                        <td class="py-2.5 text-slate-500 italic">
                                            {{ $timesheet->note ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-xs text-slate-400 py-2">Aucun temps n'a encore été déclaré sur cette tâche.</p>
                @endif
            </div>

        </div>

        <!-- Colonne Latérale -->
        <div class="space-y-6">

            <!-- Mise à jour du Statut -->
            <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-5 space-y-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Mettre à jour le statut</h3>
                <form action="{{ route('dev.tasks.update-status', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-2">
                        <select name="status" class="w-full text-xs border border-slate-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>À faire</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-md transition">
                            OK
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ajout des Heures -->
            <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-5 space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Déclarer du temps passé</h3>

                <form action="{{ route('dev.tasks.timesheets.store', $task) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label for="hours" class="block text-[11px] font-semibold text-slate-600 mb-1">Nombre d'heures</label>
                        <input type="number" step="0.5" min="0.5" max="24" name="hours" id="hours" required placeholder="Ex: 2.5"
                            class="w-full text-xs border border-slate-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="note" class="block text-[11px] font-semibold text-slate-600 mb-1">Commentaire (optionnel)</label>
                        <textarea name="note" id="note" rows="2" placeholder="Description des travaux effectués..."
                            class="w-full text-xs border border-slate-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-md transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-4 h-4"></i> Enregistrer les heures
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection