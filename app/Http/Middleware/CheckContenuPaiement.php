<?php

namespace App\Http\Middleware;

use App\Enums\PaiementStatut;
use App\Models\Contenu;
use App\Models\Paiement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckContenuPaiement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Vérifier si le user a payé pour accéder au contenu
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Récupérer le paramètre de la route (supporte 'contenu' ou 'id')
        $contenuParam = $request->route('contenu') ?? $request->route('id');

        // Si c'est déjà un objet Contenu (injecté par le controller)
        if ($contenuParam instanceof Contenu) {
            $contenu = $contenuParam;
        } else {
            // Sinon charger le contenu
            $contenu = Contenu::find($contenuParam);
        }

        // Vérifier si le contenu existe
        if (!$contenu) {
            Log::error('Contenu introuvable', ['param' => $contenuParam]);
            abort(404, 'Contenu non trouvé');
        }

        $user = auth()->user();

        // Admin = accès direct
        if ($user->isAdmin()) {
            Log::info('Accès autorisé: admin', [
                'user_id' => $user->id,
                'contenu_id' => $contenu->id
            ]);
            return $next($request);
        }

        // Vérifier paiement avec cache
        $cacheKey = "user_{$user->id}_contenu_{$contenu->id}_paid";

        $hasAccess = Cache::remember($cacheKey, 3600, function () use ($user, $contenu) {
            $conditions = [
                ['user_id', '=', $user->id],
                ['contenu_id', '=', $contenu->id],
                ['statut', '=', PaiementStatut::SUCCESS->value],
            ];

            return Paiement::where($conditions)->exists();
        });

        if ($hasAccess) {
            Log::info('Accès autorisé: paiement validé', [
                'user_id' => $user->id,
                'contenu_id' => $contenu->id
            ]);
            return $next($request);
        }

        // Accès refusé
        Log::warning('Accès refusé: paiement requis', [
            'user_id' => $user->id,
            'contenu_id' => $contenu->id
        ]);

        return  abort(403,'Vous devriez payez pour acceder au details du contenu');
    }
}
