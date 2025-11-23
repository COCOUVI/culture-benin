<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return  view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data =$request->validate([
            'nom' => 'required|unique:roles,nom',
        ],
        [
            'nom.required' => 'le role est requis',
            'nom.unique'  =>'Ce role existe deja'
        ]
        );
        Role::create($data);
        return redirect()->back()->with('success',"le role a été crée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //




    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
       return view('roles.edit', compact('role'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //

        $data =$request->validate([
            'nom' => 'required|unique:roles,nom',
        ],
            [
                'nom.required' => 'le role est requis',
                'nom.unique'  =>'Ce role existe deja'
            ]
        );
        $role->update($data);
        return redirect()->back()->with('success',"le role mise a été  jour avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return redirect()->back()->with('success',"le role a été supprimée avec succès");
    }
}
