<?php

namespace App\Http\Controllers;

use App\Models\TypeContenu;
use Illuminate\Http\Request;

class TypeContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $typeContenus = TypeContenu::all();

        return view('TypeContenu.index', compact('typeContenus'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('TypeContenu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'nom' => 'required|unique:type_contenus',
        ],[
            'nom.required' => 'le nom est obligatoire',
            'nom.unique' => 'ce type de contenu existe deja'
        ]);

        TypeContenu::create($data);

        return redirect()->back()->with(["success"=>"le Type contenu  a été crée avec succes",'toast_id' => uniqid()]);

    }

    /**
     * Display the specified resource.
     *
     */
    public function show(TypeContenu $typeContenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeContenu $typeContenu)
    {
        //
        return view('TypeContenu.edit', compact('typeContenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeContenu $typeContenu)
    {
        //
        $data = $request->validate([
            'nom' => 'required|unique:type_contenus',
        ],[
            'nom.required' => 'le nom est obligatoire',
            'nom.unique' => 'ce type media existe deja'
        ]);
        $typeContenu->update($data);
        return redirect()->back()->with("success","le Type de contenu  a été mise a jour avec succes");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeContenu $typeContenu)
    {
        //
        $typeContenu->delete();
        return redirect()->back()->with("success","le type de contenu a été supprimer avec sucess");
    }
}
