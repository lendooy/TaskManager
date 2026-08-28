@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Tableau de bord Administrateur')
@section('page_subtitle', 'Vue d\'ensemble des statistiques du système')

@section('content')
<!-- Cartes de Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white p-5 rounded-lg border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Utilisateurs</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_users'] }}</h3>
        </div>
        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <i data-lucide="users" class="w-5 h-5"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-lg border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Projets</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_projects'] }}</h3>
        </div>
        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <i data-lucide="folder-kanban" class="w-5 h-5"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-lg border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tâches totales</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_tasks'] }}</h3>
        </div>
        <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
            <i data-lucide="check-square" class="w-5 h-5"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-lg border border-slate-200/80 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Heures Saisies</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total_hours'] ?? 0 }} h</h3>
        </div>
        <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
            <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
    </div>
</div>

<!-- Tableaux Récapitulatifs -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Derniers Utilisateurs -->
    <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-slate-900">Derniers Utilisateurs Inscrits</h2>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-indigo-600 hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentUsers as $user)
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                        <p class="text-slate-500">{{ $user->email }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-medium">
                        {{ $user->role->name ?? 'Sans rôle' }}
                    </span>
                </div>
            @empty
                <p class="text-xs text-slate-500 py-2">Aucun utilisateur enregistré.</p>
            @endforelse
        </div>
    </div>

    <!-- Derniers Projets -->
    <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-slate-900">Projets Récents</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentProjects as $project)
                <div class="py-2.5 flex items-center justify-between text-xs">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $project->name }}</p>
                        <p class="text-slate-500">Chef : {{ $project->chef->name ?? 'Non assigné' }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-medium">
                        {{ $project->status }}
                    </span>
                </div>
            @empty
                <p class="text-xs text-slate-500 py-2">Aucun projet disponible.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection