@extends('layouts.app')

@section('title', 'Nouveau Projet')
@section('page_title', 'Gestion des Projets')
@section('page_subtitle', 'Créer un projet')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm p-6">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
        <h2 class="text-base font-bold text-slate-900">Créer un nouveau projet</h2>
        <a href="{{ route('chef.projects.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-800 flex items-center gap-1 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour
        </a>
    </div>

    <form action="{{ route('chef.projects.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Nom du projet -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Nom du projet <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                placeholder="Ex: Refonte de l'interface"
                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date limite (Deadline) -->
        <div>
            <label for="deadline" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Date limite (Optionnelle)
            </label>
            <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('deadline') border-red-500 @enderror">
            @error('deadline')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                Description
            </label>
            <textarea name="description" id="description" rows="4"
                placeholder="Détails, exigences et objectifs du projet..."
                class="w-full px-3 py-2 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('chef.projects.index') }}"
                class="px-4 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-md transition">
                Annuler
            </a>
            <button type="submit"
                class="px-4 py-2 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Enregistrer le projet
            </button>
        </div>
    </form>
</div>
@endsection