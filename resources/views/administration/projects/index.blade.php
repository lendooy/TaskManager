@extends('layouts.administration')

@section('title', 'Projets - ProjEct IT')
@section('page_title', 'Gestion des Projets')
@section('page_subtitle', 'Liste globale')

@section('page_actions')
    <a href="{{ route('administration.projects.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Créer un projet</span>
    </a>
@endsection

@section('content')
    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200/80 rounded-lg flex items-center gap-2.5 text-xs text-emerald-900 font-medium">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 stroke-[2]"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table des Projets Style SaaS / Figma -->
    <div class="bg-white rounded-lg border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 bg-slate-50/50 text-slate-500 font-medium">
                        <th class="py-3 px-5">Projet</th>
                        <th class="py-3 px-5">Statut</th>
                        <th class="py-3 px-5">Tâches assosiées</th>
                        <th class="py-3 px-5 text-right">Date limite</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-normal">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-5">
                                <p class="font-semibold text-slate-900 text-xs">{{ $project->name }}</p>
                                @if($project->description)
                                    <p class="text-[11px] text-slate-500 font-normal mt-0.5">{{ Str::limit($project->description, 70) }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-5">
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
                            <td class="py-3.5 px-5 text-slate-600 font-medium">{{ $project->tasks_count }} tâche(s)</td>
                            <td class="py-3.5 px-5 text-right text-slate-500 font-mono text-[11px]">
                                {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 font-medium">
                                Aucun projet trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
        <div class="pt-2">
            {{ $projects->links() }}
        </div>
    @endif
@endsection