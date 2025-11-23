<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\Contenu;
use App\Models\Media;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $medias = Media::with(['contenu', 'type_media'])->get();
        return view('medias.index',compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $contenus = Contenu::all();
        $types = TypeMedia::all();
        return view('medias.create',compact('contenus','types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {

        $data = $request->validated();

        // Upload du fichier
        if ($request->hasFile('chemin')) {
            $data['chemin'] = $request->file('chemin')->store('medias', 'public');
        }

        Media::create($data);

        return redirect()->back()
            ->with('success', 'Media ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
        return view('medias.show',compact('media'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
        $contenus = Contenu::all();
        $typesMedia = TypeMedia::all();
        return view('medias.edit',compact('media','contenus','typesMedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMediaRequest $request, Media $media)
    {
        // Récupérer les données validées
        $data = $request->validated();

        // Vérifier si un nouveau fichier a été uploadé
        if ($request->hasFile('chemin')) {

            $file = $request->file('chemin');

            // Générer un nom unique pour éviter les collisions
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Déplacer le fichier dans storage/app/public/media
            $file->storeAs('public/media', $filename);

            // Supprimer l'ancien fichier si il existe
            if ($media->chemin && Storage::exists('public/media/' . $media->chemin)) {
                Storage::delete('public/media/' . $media->chemin);
            }

            // Mettre à jour le chemin dans les données
            $data['chemin'] = $filename;
        } else {
            // Si aucun nouveau fichier, ne pas modifier le champ 'chemin'
            unset($data['chemin']);
        }

        // Mettre à jour le reste des champs
        $media->update($data);

        // Retour avec succès
        return redirect()->back()->with('success', 'Le média a été mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
        $media->delete();
        return redirect()->back()->with('success', 'Le média a été  supprimée avec succès !');
    }
}
