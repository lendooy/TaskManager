<?php

namespace App\Http\Controllers\Developpeur;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function store(Request $request, Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'hours' => ['required', 'numeric', 'min:0.25', 'max:24'],
            'logged_at' => ['required', 'date'],
            'note' => ['nullable', 'string'],
        ]);

        Timesheet::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'hours' => $request->hours,
            'logged_at' => $request->logged_at,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Temps de travail enregistré.');
    }
}