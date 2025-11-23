<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContenuRequest;
use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\TypeContenu;
use App\Models\User;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contenus = Contenu::with(['langue','region','type_contenu','auteur'])->get();
        return view('contenus.index',compact('contenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::all();
        $regions = Region::all();
        $langues = Langue::all();
        $types = TypeContenu::all();
        return view('contenus.create',compact('regions','langues','types','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContenuRequest $request)
    {
        //
        Contenu::create($request->validated());

        return redirect()->back()->with('success','contenu crée avec succès');

    }

    /**
     * Display the specified resource.
     */
    public function show(Contenu $contenu)
    {
        //

        return view('contenus.show',compact('contenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contenu $contenu)
    {
        //
        return view('contenus.edit',compact('contenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contenu $contenu)
    {
        // 1. Validation des champs
        $validated = $request->validate([
            'titre'             => 'required|string|max:255',
            'texte'             => 'nullable|string',
            'statut'            => 'required|in:actif,inactif',
            'id_auteur'         => 'required|exists:users,id',
            'region_id'         => 'required|exists:regions,id',
            'langue_id'         => 'required|exists:langues,id',
            'type_contenu_id'   => 'required|exists:type_contenus,id',
        ]);

        // 2. Mise à jour du contenu
        $contenu->update($validated);

        // 3. Message de succès + redirection
        return redirect()
            ->back()
            ->with('success', 'Le contenu a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenu $contenu)
    {
        //
        $contenu->delete();
        return redirect()->back()->with('success','contenu supprimée avec succès');
    }
}
