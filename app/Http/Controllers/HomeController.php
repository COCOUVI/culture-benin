<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\Langue;
use App\Models\User;

class HomeController extends Controller
{
    public function edit($id)
    {
        return view('langues.edit',compact('id'));
    }
    public function index()
    {
        // Statistiques clés
        $totalContenus = Contenu::count();
        $totalLangues = Contenu::distinct('langue_id')->count('langue_id');
        $totalCommentaires = Commentaire::count();
        $totalUsers = User::count();

        // Contenus par langue (pour le diagramme en barres)
        $contenusParLangue = Contenu::with('langue')
            ->select('langue_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('langue_id')
            ->get()
            ->mapWithKeys(fn($c) => [$c->langue->nom_langue ?? 'Inconnue' => $c->total]);

        // Commentaires par contenu (diagramme semi-circulaire)
        $commentairesParContenu = Contenu::withCount('commentaires')
            ->get()
            ->pluck('commentaires_count', 'titre');

        return view('welcome', compact(
            'totalContenus',
            'totalLangues',
            'totalCommentaires',
            'totalUsers',
            'contenusParLangue',
            'commentairesParContenu'
        ));
    }
}
