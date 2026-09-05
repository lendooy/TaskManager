@extends('layouts.app')

@section('title', 'Tableau de bord Développeur')
@section('page_title', 'Espace Développeur')
@section('page_subtitle', 'Vue d\'ensemble de vos projets et tâches')

@section('content')
<div class="space-y-6">

    <!-- Cartes de Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- À faire -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">À Faire</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['todo_tasks'] }}</h3>
                </div>
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Tâches en attente de traitement</p>
        </div>

        <!-- En cours -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">En Cours</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['in_progress_tasks'] }}</h3>
                </div>
                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="loader" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Tâches actuellement en cours</p>
        </div>

        <!-- Terminées -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Terminées</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['completed_tasks'] }}</h3>
                </div>
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Tâches livrées avec succès</p>
        </div>

        <!-- Temps Passé (Timesheet) -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Temps Passé</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_hours'] }} h</h3>
                </div>
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="timer" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Cumul total d'heures saisies</p>
        </div>

    </div>

    <!-- Section Projets Assignés & Tâches Récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Mes Projets (2 colonnes) -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Mes Projets Assignés</h2>
                <span class="text-xs text-slate-400 font-medium">{{ $projects->count() }} projet(s)</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($projects as $project)
                    <div class="p-4 rounded-lg border border-slate-200/60 bg-slate-50/50 space-y-3">
                        <div class="flex items-start justify-between">
                            <h3 class="text-xs font-bold text-slate-900">{{ $project->name }}</h3>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-700">
                                {{ $project->total_tasks }} tâche(s)
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 line-clamp-2">
                            {{ $project->description ?: 'Aucune description disponible.' }}
                        </p>
                    </div>
                @empty
                    <div class="col-span-2 py-6 text-center text-slate-400 text-xs">
                        Vous n'êtes assigné à aucun projet pour le moment.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tâches Récentes (1 colonne) -->
        <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Tâches Récentes</h2>
                <a href="{{ route('dev.tasks.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Tout voir</a>
            </div>

            <div class="space-y-3">
                @forelse($recentTasks as $task)
                    <a href="{{ route('dev.tasks.show', $task) }}" class="block p-3 rounded-lg border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition space-y-1">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $task->title }}</p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400">
                            <span>{{ $task->project->name ?? 'N/A' }}</span>
                            @switch($task->status)
                                @case('completed')
                                @case('terminé')
                                    <span class="text-emerald-600 font-medium">Terminée</span>
                                    @break
                                @case('in_progress')
                                @case('en_cours')
                                    <span class="text-blue-600 font-medium">En cours</span>
                                    @break
                                @default
                                    <span class="text-amber-600 font-medium">À faire</span>
                            @endswitch
                        </div>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Aucune tâche disponible.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection