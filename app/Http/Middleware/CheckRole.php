<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Gère la vérification des rôles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si l'utilisateur n'est pas connecté ou s'il n'a pas le rôle requis
        if (! $request->user() || ! in_array($request->user()->role?->name, $roles)) {
            // Renvoie une erreur 403 (Accès interdit)
            abort(403, 'Accès non autorisé à cette ressource.');
        }

        return $next($request);
    }
}