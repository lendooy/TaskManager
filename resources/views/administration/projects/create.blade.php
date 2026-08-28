@extends('layouts.administration')

@section('title', 'Nouveau Projet - ProjEct IT')
@section('page_title', 'Projets')
@section('page_subtitle', 'Nouveau projet')

@section('page_actions')
    <a href="{{ route('administration.projects.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-200 bg-white shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5 stroke-[2]"></i>
        <span>Retour</span>
    </a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Créer un nouveau projet</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Renseignez les informations de base pour démarrer le projet.</p>
        </div>

        <form action="{{ route('administration.projects.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Champ Nom -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nom du Projet <span class="text-emerald-600">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Migration Serveur Cloud" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                @error('name') <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Champ Description -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Détails et objectifs du projet..." class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">{{ old('description') }}</textarea>
            </div>

            <!-- Statut et Date limite -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Statut Initial <span class="text-emerald-600">*</span></label>
                    <select name="status" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                        <option value="pending">En attente</option>
                        <option value="in_progress" selected>En cours</option>
                        <option value="completed">Terminé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Date limite (Deadline)</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>

            <!-- Actions du formulaire -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('administration.projects.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                    <span>Enregistrer le projet</span>
                </button>
            </div>
        </form>
    </div>
@endsection