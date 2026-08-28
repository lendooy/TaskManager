@extends('layouts.administration')

@section('title', 'Gestion des Rôles - ProjEct IT')
@section('page_title', 'Rôles & Permissions')
@section('page_subtitle', 'Niveaux d’accès des utilisateurs')

@section('page_actions')
    <a href="{{ route('administration.roles.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 shadow-sm transition">
        <i data-lucide="plus" class="w-3.5 h-3.5 stroke-[2.5]"></i>
        <span>Nouveau rôle</span>
    </a>
@endsection

@section('content')
    <!-- Notification -->
    @if(session('success'))
        <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-200/80 rounded-lg flex items-center gap-2.5 text-xs text-emerald-900 font-medium">
            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 stroke-[2]"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @error('error')
        <div class="mb-4 p-3.5 bg-red-50 border border-red-200/80 rounded-lg flex items-center gap-2.5 text-xs text-red-900 font-medium">
            <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 stroke-[2]"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror

    <!-- Grille des Rôles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($roles as $role)
            <div class="bg-white rounded-lg border border-slate-200/80 p-4 shadow-sm flex flex-col justify-between hover:border-slate-300 transition">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-md bg-slate-100 text-slate-700">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </span>
                            <h3 class="text-xs font-semibold text-slate-900">{{ $role->name }}</h3>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-slate-600 bg-slate-100 rounded-full">
                            {{ $role->users_count }} utilisateur(s)
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 line-clamp-2 mt-1">
                        {{ $role->description ?? 'Aucune description fournie pour ce rôle.' }}
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <a href="{{ route('administration.roles.edit', $role) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-600 hover:text-slate-900 transition flex items-center gap-1">
                        <i data-lucide="edit-2" class="w-3 h-3"></i> Éditer
                    </a>
                    
                    @if($role->users_count === 0)
                        <form action="{{ route('administration.roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer ce rôle ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-red-600 hover:text-red-700 transition flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-3 h-3"></i> Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                Aucun rôle configuré pour le moment.
            </div>
        @endforelse
    </div>
@endsection