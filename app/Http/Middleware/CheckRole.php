<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        /** @var User $user */
        $user = auth()->user();

        // Utilisateur non connecté
        if (!$user) {
            return redirect()->route('login');
        }

        // Utilisateur inactif
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Compte désactivé.']);
        }

        // L'admin bypass SAUF les dashboards des autres rôles
        if ($user->role === 'admin') {
            $uri = $request->path();
            if (str_starts_with($uri, 'opticien/') || str_starts_with($uri, 'employe/')) {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        }

        // Vérifier le rôle
        if (!in_array($user->role, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
