<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', //[cite: 4]
        'assigned_to', //[cite: 4]
        'title', //[cite: 4]
        'description', //[cite: 4]
        'status', //[cite: 4]
        'estimated_hours', //[cite: 4]
        'deadline', // Date limite imposée par le chef de projet
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class); //[cite: 4]
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to'); //[cite: 4]
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class); //[cite: 4]
    }
}