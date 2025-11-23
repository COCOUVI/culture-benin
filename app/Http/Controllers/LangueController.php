<?php

namespace App\Http\Controllers;

use App\Http\Requests\LangueRequest;
use App\Models\Langue;
use Illuminate\Http\Request;

class LangueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $langues = Langue::all();
        return view('langues.index',compact('langues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('langues.create');
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(LangueRequest $request)
    {
        //
        Langue::create($request->all());
        return redirect()->route('langues.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Langue $langue)
    {
        //
        return view('langues.show',compact('langue'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Langue $langue)
    {
        //
        return view('langues.edit',compact('langue'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Langue $langue)
    {
        $validated = $request->validate(
            [
                'code_langue' => 'required|string|max:5',
                'nom_langue' => 'required|string|max:50',
                'description' => 'nullable|string',
            ],
            [
                'code_langue.required' => 'Ce champ est obligatoire.',
                'code_langue.string' => 'Ce champ doit être du texte.',
                'code_langue.max' => 'Ce champ est trop long.',

                'nom_langue.required' => 'Ce champ est obligatoire.',
                'nom_langue.string' => 'Ce champ doit être du texte.',
                'nom_langue.max' => 'Ce champ est trop long.',

                'description.string' => 'Ce champ doit être une chaîne de caractères.',
            ]
        );

        $langue->update($validated);

        return redirect()->route('langues.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Langue $langue)
    {
        //
        $langue->delete();
        return redirect()->back()->with("success","la langue a été supprimer avec sucess");
    }
}
