<?php
namespace App\Http\Controllers\Administration;
use App\Http\Controllers\Controller;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Liste des rôles et comptage des utilisateurs associés
     */
    public function index()
    {
        $roles = Role::withCount('users')->get();

        return view('administration.roles.index', compact('roles'));
    }

    /**
     * Formulaire de création de rôle
     */
    public function create()
    {
        return view('administration.roles.create');
    }

    /**
     * Enregistrement d'un nouveau rôle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Role::create($validated);

        return redirect()->route('administration.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Role $role)
    {
        return view('administration.roles.edit', compact('role'));
    }

    /**
     * Mise à jour du rôle
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $role->update($validated);

        return redirect()->route('administration.roles.index')
            ->with('success', 'Rôle mis à jour.');
    }

    /**
     * Suppression d'un rôle
     */
    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->withErrors([
                'error' => 'Impossible de supprimer un rôle attribué à des utilisateurs.'
            ]);
        }

        $role->delete();

        return redirect()->route('administration.roles.index')
            ->with('success', 'Rôle supprimé.');
    }
}