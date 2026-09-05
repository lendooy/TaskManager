@extends('layouts.administration')

@section('title', 'Dashboard - ProjEct IT')
@section('page_title', 'Tableau de bord')
@section('page_subtitle', 'Vue d\'ensemble')

@section('page_actions')
    <a href="{{ route('administration.projects.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Nouveau projet</span>
    </a>
@endsection

@section('content')
    <!-- Métriques minimalistes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Projets -->
        <div class="bg-white p-4 rounded-lg border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Projets</p>
                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $totalProjects }}</p>
            </div>
            <i data-lucide="folder" class="w-4 h-4 text-slate-400 stroke-[1.75]"></i>
        </div>

        <!-- Tâches en cours -->
        <div class="bg-white p-4 rounded-lg border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tâches en cours</p>
                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $totalTasks - $completedTasks }}</p>
            </div>
            <i data-lucide="list-todo" class="w-4 h-4 text-slate-400 stroke-[1.75]"></i>
        </div>

        <!-- Tâches Terminées -->
        <div class="bg-white p-4 rounded-lg border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tâches Terminées</p>
                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $completedTasks }}</p>
            </div>
            <i data-lucide="check-circle" class="w-4 h-4 text-slate-400 stroke-[1.75]"></i>
        </div>

        <!-- Heures Saisies -->
        <div class="bg-white p-4 rounded-lg border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Heures Saisies</p>
                <p class="text-xl font-bold text-slate-900 mt-0.5">{{ $totalHoursLogged }} h</p>
            </div>
            <i data-lucide="clock" class="w-4 h-4 text-slate-400 stroke-[1.75]"></i>
        </div>
    </div>

    <!-- Table des Projets Récents -->
    <div class="bg-white rounded-lg border border-slate-200/80 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-slate-200/80 flex justify-between items-center bg-white">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Projets Récents</h2>
            <a href="{{ route('administration.projects.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">Voir tout &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 bg-slate-50/50 text-slate-500 font-medium">
                        <th class="py-2.5 px-5">Nom du projet</th>
                        <th class="py-2.5 px-5">Statut</th>
                        <th class="py-2.5 px-5">Tâches associées</th>
                        <th class="py-2.5 px-5 text-right">Date limite</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse($recentProjects as $project)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-5 font-semibold text-slate-900">{{ $project->name }}</td>
                            <td class="py-3 px-5">
                                @if($project->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Terminé
                                    </span>
                                @elseif($project->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-slate-800 bg-slate-100 border border-slate-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span> En cours
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-slate-500 bg-slate-50 border border-slate-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-slate-600">{{ $project->tasks_count }} tâche(s)</td>
                            <td class="py-3 px-5 text-right text-slate-500 font-mono text-[11px]">
                                {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">
                                Aucun projet enregistré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection