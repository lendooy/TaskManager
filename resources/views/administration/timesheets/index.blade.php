@extends('layouts.administration')

@section('title', 'Saisies de Temps - ProjEct IT')
@section('page_title', 'Saisies de temps')
@section('page_subtitle', 'Suivi global des heures déclarées par l’équipe')

@section('page_actions')
    <a href="{{ route('administration.timesheets.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3.5 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Déclarer du temps</span>
    </a>
@endsection

@section('content')
    <!-- Alerts de feedback -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200/80 rounded-md flex items-center justify-between text-xs text-emerald-800">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200/80 rounded-md flex items-center justify-between text-xs text-red-800">
            <div class="flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    @endif

    <!-- Container Tableau SaaS -->
    <div class="bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Historique des heures</h2>
            <span class="text-[11px] text-slate-500">Total : <strong class="text-slate-800 font-semibold">{{ $timesheets->total() }}</strong> entrée(s)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/30 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Membre</th>
                        <th class="py-3 px-4">Tâche / Projet</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-center">Durée</th>
                        <th class="py-3 px-4">Note</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($timesheets as $timesheet)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Membre -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold uppercase">
                                        {{ substr($timesheet->user->name ?? 'U', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $timesheet->user->name ?? 'Non assigné' }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $timesheet->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Tâche / Projet -->
                            <td class="py-3 px-4">
                                <p class="font-medium text-slate-800">{{ $timesheet->task->title ?? 'Tâche supprimée' }}</p>
                                @if(isset($timesheet->task->project))
                                    <span class="inline-flex items-center gap-1 text-[10px] text-slate-500 mt-0.5">
                                        <i data-lucide="folder" class="w-3 h-3 text-slate-400"></i>
                                        {{ $timesheet->task->project->name }}
                                    </span>
                                @endif
                            </td>

                            <!-- Date (logged_at) -->
                            <td class="py-3 px-4 whitespace-nowrap text-slate-600">
                                {{ \Carbon\Carbon::parse($timesheet->logged_at)->format('d/m/Y') }}
                            </td>

                            <!-- Durée (hours) -->
                            <td class="py-3 px-4 whitespace-nowrap text-center">
                                <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-200/60 font-semibold text-[11px] px-2 py-0.5 rounded-md">
                                    {{ number_format($timesheet->hours, 2) }} h
                                </span>
                            </td>

                            <!-- Note -->
                            <td class="py-3 px-4 max-w-xs truncate text-slate-500 text-[11px]">
                                {{ $timesheet->note ?? '—' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('administration.timesheets.edit', $timesheet) }}" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition" title="Éditer">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <form action="{{ route('administration.timesheets.destroy', $timesheet) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette saisie de temps ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition" title="Supprimer">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i data-lucide="clock" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <p class="text-xs font-medium text-slate-500">Aucune saisie de temps enregistrée pour le moment.</p>
                                <a href="{{ route('administration.timesheets.create') }}" class="inline-block mt-3 text-xs font-semibold text-emerald-600 hover:underline">
                                    Déclarer vos premières heures
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($timesheets->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $timesheets->links() }}
            </div>
        @endif
    </div>
@endsection