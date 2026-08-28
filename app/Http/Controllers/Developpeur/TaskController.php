<?php

namespace App\Http\Controllers\Developpeur;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assigned_to', auth()->id())
            ->with(['project', 'timesheets'])
            ->latest()
            ->paginate(10);

        return view('dev.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403, 'Accès refusé à cette tâche.');
        }

        $task->load(['project', 'timesheets']);

        return view('dev.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:todo,in_progress,completed'],
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la tâche mis à jour.');
    }
}