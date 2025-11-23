<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Langue;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::with(['role','langue'])->get();

        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
        $langues = Langue::all();
        return view('users.create',compact('roles','langues'));
    }

    /**
     * Store a newly created resource in storage.
     */

        //

        public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos_users', 'public');
        }

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'date_naissance' => $validated['date_naissance'],
            'statut' => $validated['statut'],
            'id_role' => $validated['id_role'],
            'id_langue' => $validated['id_langue'],
            'photo' => $validated['photo'] ?? null,
            'password' => Hash::make($validated['password']),
            'sexe' => $validated['sexe'],
        ]);

        return redirect()
            ->route('users.create')
            ->with('success', 'Utilisateur créé avec succès');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        $langues = Langue::all();
        return view('users.edit',compact('user','roles','langues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::exists($user->photo)) {
                Storage::delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users/photos', 'public');
        }

        $user->update($data);

        return redirect()->back()
            ->with('success', 'Utilisateur mis à jour avec succès !');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->back()->with('success','Utilisateur supprimer avec succès');
    }
}
