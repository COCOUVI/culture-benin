<?php

namespace App\Http\Controllers;

use App\Models\TypeMedia;
use Illuminate\Http\Request;

class TypeMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mediaTypes = TypeMedia::all();
        return view('TypeMedia.index', compact('mediaTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('TypeMedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $data = $request->validate([
             'nom' => 'required|unique:type_medias',
         ],[
             'nom.required' => 'le nom est obligatoire',
             'nom.unique' => 'ce type media existe deja'
         ]);

         TypeMedia::create($data);

        return redirect()->back()->with("success","le Type media a été crée avec succes");
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeMedia $typeMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeMedia $typeMedia)
    {
        //
        return view('Typemedia.edit',compact('typeMedia'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeMedia $typeMedia)
    {
        //
        $data = $request->validate([
            'nom' => 'required|unique:type_media',
        ],[
            'nom.required' => 'le nom est obligatoire',
            'nom.unique' => 'ce type media existe deja'
        ]);
        $typeMedia->update($data);
        return redirect()->back()->with("success","le Type media a été mise a jour avec succes");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeMedia $typeMedia)
    {
        //
        $typeMedia->delete();
        return redirect()->back()->with("success","le Type media a été  suppimé avec succes");
    }
}
