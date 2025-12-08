<?php
// app/Http/Middleware/AdminOuManager.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOuManager
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Vérifier admin ou manager via les méthodes du modèle
        if (!$user->isAdminOrManager()) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }

}
