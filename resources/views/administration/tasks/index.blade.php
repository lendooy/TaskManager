@extends('layouts.administration')

@section('title', 'Tâches - ProjEct IT')
@section('page_title', 'Gestion des Tâches')
@section('page_subtitle', 'Liste des tâches')

@section('page_actions')
    <a href="{{ route('administration.tasks.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Créer une tâche</span>
    </a>
@endsection

@section('content')
    <!-- Notification -->
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200/80 rounded-lg flex items-center gap-2.5 text-xs text-emerald-900 font-medium">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 stroke-[2]"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table des Tâches -->
    <div class="bg-white rounded-lg border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 bg-slate-50/50 text-slate-500 font-medium">
                        <th class="py-3 px-5">Tâche</th>
                        <th class="py-3 px-5">Projet associé</th>
                        <th class="py-3 px-5">Assigné à</th>
                        <th class="py-3 px-5">Statut</th>
                        <th class="py-3 px-5 text-right">Estimation</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $task->title }}</td>
                            <td class="py-3.5 px-5 text-slate-700 font-medium">{{ $task->project->name ?? '-' }}</td>
                            <td class="py-3.5 px-5 text-slate-600">
                                @if($task->assignee)
                                    <span class="inline-flex items-center gap-1.5 font-medium text-slate-800">
                                        <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-700 font-bold text-[10px] flex items-center justify-center">
                                            {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                        </span>
                                        {{ $task->assignee->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Non assigné</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
                                @if($task->status === 'done')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Terminé
                                    </span>
                                @elseif($task->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-slate-800 bg-slate-100 border border-slate-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span> En cours
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 text-[11px] font-semibold text-slate-500 bg-slate-50 border border-slate-200/60 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> À faire
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-right text-slate-500 font-mono text-[11px]">
                                {{ $task->estimated_hours ? $task->estimated_hours . ' h' : '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <a href="{{ route('administration.tasks.edit', $task) }}" class="inline-flex items-center gap-1 text-slate-600 hover:text-emerald-600 font-medium transition">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5 stroke-[2]"></i>
                                    <span>Éditer</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                Aucune tâche enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
        <div class="pt-2">
            {{ $tasks->links() }}
        </div>
    @endif
@endsection