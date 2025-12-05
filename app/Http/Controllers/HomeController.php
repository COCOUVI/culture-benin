<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Media;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector;


class HomeController extends Controller
{
    public function edit($id)
    {
        return view('langues.edit', compact('id'));
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
            'commentairesParContenu',

        ));
    }

    public function redirectCustomize()
    {
        $user = auth()->user();

        // Rediriger en fonction du rôle de l'utilisateur
        return match ($user->id_role) {
            4 => redirect()->route('home'), // Admin
            5 => redirect()->route('home'), // Manager
            default => redirect()->route('accueil'), // Utilisateur standard
        };
    }

    public function accueil()
    {
        $nbr_contenus = Contenu::count();
        $nbr_langues = Langue::count();
        $contenus = Contenu::with(['region', 'langue', 'type_contenu'])
            ->where('statut', 'actif')
            ->latest()
            ->take(9) // 3 par slide × 4 slides
            ->get();
        // Chunk into slides (3 per slide)
        $slides = $contenus->chunk(3);
        $medias = \App\Models\Media::with(['contenu', 'type_media'])
            ->latest()
            ->limit(4)
            ->get();
        $totalCommentaires= Commentaire::count();
        $contributeurs= User::has('contenus')->count();
        $totalUsers = User::count();
        $langues = Langue::take(3)->get();
        $regions = Region::take(4)->get();


        return view('home.index', compact('nbr_contenus', 'nbr_langues', 'contenus', 'slides','medias','totalCommentaires','totalUsers','contributeurs','langues','regions'));
    }

    public function all(Request $request)
    {
        $query = Contenu::with(['type_contenu', 'langue', 'region', 'media', 'auteur']);

        // Filtre par recherche (titre ou texte)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                    ->orWhere('texte', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par langue
        if ($request->filled('langue_id')) {
            $query->where('langue_id', $request->langue_id);
        }

        // Filtre par région
        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }

        // Pagination
        $contents = $query->latest()->paginate(12);

        // Récupérer toutes les langues et régions pour les filtres
        $langues = Langue::orderBy('nom_langue')->get();
        $regions = Region::orderBy('nom_region')->get();

        return view('home.contents', compact('contents', 'langues', 'regions'));
    }

    public function ShowContentDetail(Contenu $contenu)
    {
        // Charger les relations
        $contenu->load([
            'media',
            'type_contenu',
            'langue',
            'region',
            'auteur',
            'commentaires' => function ($query) {
                $query->with('user')->latest(); // Trier par plus récent
            }
        ]);

        // Calculer les statistiques
        $noteMoyenne = $contenu->commentaires->avg('note') ?? 0;
        $nombreCommentaires = $contenu->commentaires->count();

        // Vérifier si l'utilisateur connecté a déjà commenté
        $userComment = null;
        if (auth()->check()) {
            $userComment = $contenu->commentaires->where('id_user', auth()->id())->first();
        }

        return view('home.detail', compact('contenu', 'noteMoyenne', 'nombreCommentaires', 'userComment'));
    }

    public function StoreUserComment(Request $request, Contenu $contenu)
    {
        $validated = $request->validate([
            'commentaire' => 'required|string|min:3|max:1000',
            'note' => 'required|integer|between:1,5',
        ], [
            'commentaire. required' => 'Le commentaire est obligatoire.',
            'commentaire.min' => 'Minimum 3 caractères.',
            'commentaire.max' => 'Maximum 1000 caractères.',
            'note.required' => 'Sélectionnez une note.',
            'note.between' => 'La note doit être entre 1 et 5.',
        ]);

        // Vérifier doublon
        if (Commentaire::where('id_user', auth()->id())->where('id_contenu', $contenu->id)->exists()) {
            return back()->withErrors(['commentaire' => 'Vous avez déjà commenté ce contenu.'])->withInput();
        }

        // Créer
        Commentaire::create([
            'commentaire' => trim($validated['commentaire']),
            'note' => $validated['note'],
            'id_user' => auth()->id(),
            'id_contenu' => $contenu->id,
        ]);

        return back()->with('success', '✅ Commentaire publié ! ');
    }
    public  function  destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        return back()->with('success', '✅ Commentaire supprimé !');
    }

    public function showmedias(Request $request)
    {
        $query = Media::with(['contenu', 'type_media']);

        // Filtre par type de média
        if ($request->has('type')) {
            $query->where('id_type_media', $request->type);
        }

        // Trier par type de média
        $query->orderBy('id_type_media');

        // Pagination
        $medias = $query->paginate(12);

        // Récupérer les statistiques
        $stats = [
            'total' => Media::count(),
            'images' => Media::whereHas('type_media', function($q) {
                $q->whereIn('nom', ['Image', 'image', 'Photo', 'photo']);
            })->count(),
            'videos' => Media::whereHas('type_media', function($q) {
                $q->whereIn('nom', ['Vidéo', 'Video', 'video']);
            })->count(),
            'audios' => Media::whereHas('type_media', function($q) {
                $q->whereIn('nom', ['Audio', 'audio', 'Son']);
            })->count(),
        ];

        $typesMedia = \App\Models\TypeMedia::all();

        return view('home.media', compact('medias', 'stats', 'typesMedia'));
    }
    public function OneMedia(Media $media)
    {
        return view('home.media-details', compact('media'));


    }
}
