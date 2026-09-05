@extends('layouts.app')

@section('title', 'Tableau de bord Chef de Projet')
@section('page_title', 'Espace Chef de Projet')
@section('page_subtitle', 'Vue d\'ensemble des projets et des équipes')

@section('content')
<div class="space-y-6">

    <!-- Cartes de Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Projets -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Projets Totaux</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_projects'] }}</h3>
                </div>
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="folder-kanban" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Projets enregistrés dans la plateforme</p>
        </div>

        <!-- Total Tâches -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Tâches Totales</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_tasks'] }}</h3>
                </div>
                <div class="p-2.5 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="check-square" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Ensemble des tâches créées</p>
        </div>

        <!-- Tâches Terminées -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Tâches Terminées</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['completed_tasks'] }}</h3>
                </div>
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Livrables validés avec succès</p>
        </div>

        <!-- Total Heures Consommées -->
        <div class="bg-white rounded-lg border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase">Heures Saisies</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_hours'] }} h</h3>
                </div>
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3">Temps global consommé par les équipes</p>
        </div>

    </div>

    <!-- Section Projets & Tâches Récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Aperçu des Projets (2 colonnes) -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Projets Récents</h2>
                <a href="{{ route('chef.projects.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Gérer les projets</a>
            </div>

            <div class="space-y-4">
                @forelse($projects as $project)
                    <div class="p-4 rounded-lg border border-slate-200/60 bg-slate-50/50 space-y-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-slate-900">{{ $project->name }}</h3>
                            <span class="text-[11px] text-slate-400">{{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : 'Pas d\'échéance' }}</span>
                        </div>

                        <div class="text-[11px] text-slate-500 pt-1">
                            <span>{{ $project->completed_tasks_count }} / {{ $project->tasks_count }} tâches terminées</span>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-slate-400 text-xs">Aucun projet trouvé.</p>
                @endforelse
            </div>
        </div>

        <!-- Dernières Tâches (1 colonne) -->
        <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900">Activité Récente</h2>
            </div>

            <div class="space-y-3">
                @forelse($recentTasks as $task)
                    <div class="p-3 rounded-lg border border-slate-100 space-y-1">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $task->title }}</p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400">
                            <span>Assigné à : <strong class="text-slate-600">{{ $task->assignedTo->name ?? ($task->user->name ?? 'Non assigné') }}</strong></span>
                            @switch($task->status)
                                @case('completed')
                                    <span class="text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">Terminée</span>
                                    @break
                                @case('in_progress')
                                    <span class="text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded">En cours</span>
                                    @break
                                @default
                                    <span class="text-amber-600 font-medium bg-amber-50 px-2 py-0.5 rounded">À faire</span>
                            @endswitch
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Aucune activité récente.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection