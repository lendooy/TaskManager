@extends('layouts.administration')

@section('title', 'Éditer le Rôle - ProjEct IT')
@section('page_title', 'Rôles & Permissions')
@section('page_subtitle', 'Modifier le rôle : ' . $role->name)

@section('page_actions')
    <a href="{{ route('administration.roles.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-200 bg-white shadow-sm">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5 stroke-[2]"></i>
        <span>Retour</span>
    </a>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-lg border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-700">Modifier le rôle</h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Mettez à jour le nom et la description de ce niveau d'accès.</p>
        </div>

        <form action="{{ route('administration.roles.update', $role) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Nom du rôle -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nom du Rôle <span class="text-emerald-600">*</span></label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required placeholder="Ex: Développeur Senior, Chef de Projet..." class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">
                @error('name') 
                    <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Description du rôle -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Description des responsabilités et des privilèges de ce rôle..." class="w-full bg-slate-50/50 border border-slate-200 rounded-md px-3 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none transition">{{ old('description', $role->description) }}</textarea>
                @error('description') 
                    <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Informatif : Nombre d'utilisateurs affectés -->
            <div class="p-3 bg-slate-50 rounded-md border border-slate-200/60 flex items-center justify-between text-xs text-slate-600">
                <span class="flex items-center gap-1.5 font-medium">
                    <i data-lucide="users" class="w-3.5 h-3.5 text-slate-400"></i>
                    Utilisateurs associés
                </span>
                <span class="font-semibold text-slate-800 bg-slate-200/70 px-2 py-0.5 rounded-full text-[10px]">
                    {{ $role->users()->count() }} membre(s)
                </span>
            </div>

            <!-- Actions du formulaire -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <a href="{{ route('administration.roles.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
                    <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                    <span>Mettre à jour</span>
                </button>
            </div>
        </form>
    </div>
@endsection