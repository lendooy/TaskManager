<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class TimesheetController extends Controller
{
    /**
     * Affiche la liste des saisies de temps.
     */
    public function index()
    {
        $timesheets = Timesheet::with(['task.project', 'user'])
            ->orderBy('logged_at', 'desc')
            ->paginate(15);

        return view('administration.timesheets.index', compact('timesheets'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $tasks = Task::with('project')->orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('administration.timesheets.create', compact('tasks', 'users'));
    }

    /**
     * Enregistre une nouvelle saisie de temps en base de données.
     */
    public function store(Request $request)
    {
        // 1. Validation stricte des données entrantes
        $validated = $request->validate([
            'task_id'   => 'required|integer|exists:tasks,id',
            'user_id'   => 'nullable|integer|exists:users,id',
            'hours'     => 'required|numeric|min:0.1|max:24',
            'logged_at' => 'required|date',
            'note'      => 'nullable|string|max:1000',
        ], [
            'task_id.required'   => 'Veuillez sélectionner une tâche.',
            'task_id.exists'     => 'La tâche sélectionnée n’existe pas.',
            'hours.required'     => 'La durée est obligatoire.',
            'hours.numeric'      => 'La durée doit être un nombre valide.',
            'logged_at.required' => 'La date d’enregistrement est obligatoire.',
            'logged_at.date'     => 'Le format de la date est invalide.',
        ]);

        // 2. Gestion de l'utilisateur (prend l'utilisateur connecté si aucun sélectionné)
        $userId = $validated['user_id'] ?? Auth::id();

        if (!$userId) {
            return back()
                ->withInput()
                ->withErrors(['user_id' => 'Impossible d’identifier l’utilisateur connecté. Veuillez sélectionner un membre.']);
        }

        try {
            // 3. Enregistrement en BDD
            Timesheet::create([
                'task_id'   => $validated['task_id'],
                'user_id'   => $userId,
                'hours'     => $validated['hours'],
                'logged_at' => $validated['logged_at'],
                'note'      => $validated['note'] ?? null,
            ]);

            return redirect()
                ->route('administration.timesheets.index')
                ->with('success', 'La saisie de temps a bien été enregistrée.');

        } catch (Exception $e) {
            // 4. Capture et journalisation des erreurs SQL / BDD
            Log::error('Erreur lors de la création du Timesheet : ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'input'   => $request->all(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l’enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Timesheet $timesheet)
    {
        $tasks = Task::with('project')->orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('administration.timesheets.edit', compact('timesheet', 'tasks', 'users'));
    }

    /**
     * Mettre à jour une saisie de temps existante.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $validated = $request->validate([
            'task_id'   => 'required|integer|exists:tasks,id',
            'user_id'   => 'required|integer|exists:users,id',
            'hours'     => 'required|numeric|min:0.1|max:24',
            'logged_at' => 'required|date',
            'note'      => 'nullable|string|max:1000',
        ]);

        try {
            $timesheet->update($validated);

            return redirect()
                ->route('administration.timesheets.index')
                ->with('success', 'La saisie de temps a été mise à jour.');

        } catch (Exception $e) {
            Log::error('Erreur lors de la modification du Timesheet #' . $timesheet->id . ' : ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Impossible de mettre à jour la saisie : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer une saisie de temps.
     */
    public function destroy(Timesheet $timesheet)
    {
        try {
            $timesheet->delete();

            return redirect()
                ->route('administration.timesheets.index')
                ->with('success', 'La saisie de temps a été supprimée.');

        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du Timesheet #' . $timesheet->id . ' : ' . $e->getMessage());

            return back()->with('error', 'Impossible de supprimer cette saisie de temps.');
        }
    }
}