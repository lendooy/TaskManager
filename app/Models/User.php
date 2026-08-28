<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Les attributs à masquer.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtenir les attributs à caster.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relation : Un utilisateur appartient à un Rôle.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes d'aide pour les rôles (Role Helpers)
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si l'utilisateur possède un rôle spécifique par son nom.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Vérifie si l'utilisateur est Administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * Vérifie si l'utilisateur est Chef de projet.
     */
    public function isChefDeProjet(): bool
    {
        return $this->hasRole('Chef de projet');
    }

    /**
     * Vérifie si l'utilisateur est Développeur.
     */
    public function isDeveloppeur(): bool
    {
        return $this->hasRole('Développeur');
    }
    // Ajouter la relation vers les projets assignés
    public function assignedProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }

    // Projets créés (si Chef de projet)
    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }
}
