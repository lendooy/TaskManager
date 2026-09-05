@extends('layouts.app')

@section('title', 'Mes Tâches')
@section('page_title', 'Espace Développeur')
@section('page_subtitle', 'Liste de vos tâches assignées')

@section('content')
<div class="space-y-6">

    <!-- En-tête / Stats rapides -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Mes Tâches</h1>
            <p class="text-xs text-slate-500 mt-0.5">Consultez et gérez l'avancement de vos tâches.</p>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-lg flex items-center justify-between">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tableau des tâches -->
    <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-semibold text-slate-600 uppercase tracking-wider">
                        <th class="py-3 px-4">Tâche</th>
                        <th class="py-3 px-4">Projet</th>
                        <th class="py-3 px-4">Durée estimée</th>
                        <th class="py-3 px-4">Date limite</th>
                        <th class="py-3 px-4">Statut</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Titre -->
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                {{ $task->title }}
                            </td>

                            <!-- Projet -->
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700">
                                    {{ $task->project->name ?? 'Sans projet' }}
                                </span>
                            </td>

                            <!-- Durée estimée en heures -->
                            <td class="py-3 px-4">
                                <span class="font-medium text-slate-800"> {{ $task->estimated_hours ?? 0 }} h</span>
                            </td>

                            <!-- Date limite -->
                            <td class="py-3 px-4 text-slate-600">
                                @if($task->deadline)
                                    {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                                @else
                                    <span class="text-slate-400">Non définie</span>
                                @endif
                            </td>

                            <!-- Statut -->
                            <td class="py-3 px-4">
                                @switch($task->status)
                                    @case('completed')
                                    @case('terminé')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                            Terminée
                                        </span>
                                        @break

                                    @case('in_progress')
                                    @case('en_cours')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-800">
                                            En cours
                                        </span>
                                        @break

                                    @default
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                            À faire
                                        </span>
                                @endswitch
                            </td>

                            <!-- Action -->
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('dev.tasks.show', $task) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-md transition">
                                    Voir la tâche
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                <p class="text-xs">Aucune tâche ne vous est assignée pour le moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection