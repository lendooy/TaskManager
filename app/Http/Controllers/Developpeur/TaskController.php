<?php

namespace App\Http\Controllers\Developpeur;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Affiche la liste des tâches (assignées au développeur ou libres).
     */
    public function index()
    {
        $userId = auth()->id();

        $tasks = Task::with('project')
            ->where(function ($query) use ($userId) {
                $query->where('assigned_to', $userId)
                      ->orWhereNull('assigned_to');
            })
            ->latest()
            ->paginate(10);

        return view('dev.tasks.index', compact('tasks'));
    }

    /**
     * Affiche les détails d'une tâche et ses saisies de temps.
     */
    public function show(Task $task)
    {
        $task->load(['project', 'timesheets.user']);

        return view('dev.tasks.show', compact('task'));
    }

    /**
     * Mettre à jour le statut d'une tâche.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,completed',
        ]);

        $userId = auth()->id();

        // Si la tâche n'était pas assignée, on l'assigne automatiquement au développeur
        if (is_null($task->assigned_to)) {
            $task->assigned_to = $userId;
        }

        $task->status = $validated['status'];
        $task->save();

        return redirect()->route('dev.tasks.show', $task)
            ->with('success', 'Statut de la tâche mis à jour avec succès.');
    }

    /**
     * Enregistrer du temps passé (Timesheet) sur une tâche.
     */
    public function storeTimesheet(Request $request, Task $task)
    {
        $validated = $request->validate([
            'hours'     => 'required|numeric|min:0.5',
            'note'      => 'nullable|string',
            'logged_at' => 'nullable|date',
        ]);

        $userId = auth()->id();

        // Assigne automatiquement si la tâche était libre
        if (is_null($task->assigned_to)) {
            $task->update(['assigned_to' => $userId]);
        }

        // Création de la ligne de timesheet avec logged_at garanti
        $task->timesheets()->create([
            'user_id'   => $userId,
            'hours'     => $validated['hours'],
            'note'      => $validated['note'] ?? null,
            'logged_at' => $validated['logged_at'] ?? now(),
        ]);

        return redirect()->route('dev.tasks.show', $task)
            ->with('success', 'Heures enregistrées avec succès.');
    }
}