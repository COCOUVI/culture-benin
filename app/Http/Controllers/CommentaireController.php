<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\User;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $commentaires = Commentaire::with(['user','contenu'])->get();
        return view('commentaires.index',compact('commentaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
        $contenus = Contenu::all();
        return view('commentaires.create',compact('users','contenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'commentaire' => 'nullable|string|max:500',
            'note'        => 'required|integer|min:1|max:5',
            'id_user'     => 'required|exists:users,id',
            'id_contenu'  => 'required|exists:contenus,id',
        ]);

        try {
            // Création du commentaire
            Commentaire::create($validated);

            return redirect()
                ->back()
                ->with('success', 'Le commentaire a été ajouté avec succès !');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du commentaire.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
        return view('commentaires.show',compact('commentaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
        $users = User::all();
        $contenus = Contenu::all();
        return view('commentaires.edit', compact('commentaire','contenus','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        // 1️⃣ Validation des données
        $validated = $request->validate([
            'commentaire' => 'nullable|string|max:1000',
            'note'        => 'required|integer|min:1|max:5',
            'id_contenu'  => 'required|exists:contenus,id',
            'id_user'     => 'required|exists:users,id',
        ]);

        // 2️⃣ Mise à jour du commentaire
        $commentaire->update($validated);

        // 3️⃣ Retour avec succès
        return redirect()
            ->back()
            ->with('success', 'Le commentaire a été mis à jour avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commentaire $commentaire)
    {
        //
        $commentaire->delete();
        return redirect()->back()->with('success','commentaire supprimée avec succès');
    }
}
