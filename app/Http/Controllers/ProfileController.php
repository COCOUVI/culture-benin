<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Langue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $langues = Langue::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'langues' => $langues,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation UNIQUEMENT des champs du formulaire d'informations personnelles
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'sexe' => ['required', 'in:masculin,feminin'],
            'date_naissance' => ['required', 'date', 'before:today', 'after:1900-01-01'],
            'id_langue' => ['required', 'exists:langues,id'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            // Messages pour nom
            'nom. required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom. max' => 'Le nom ne doit pas dépasser 255 caractères.',

            // Messages pour prenom
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

            // Messages pour email
            'email. required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',

            // Messages pour sexe
            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.in' => 'Le sexe doit être masculin ou féminin.',

            // Messages pour date_naissance
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'date_naissance. after' => 'La date de naissance doit être postérieure à 1900.',

            // Messages pour id_langue
            'id_langue.required' => 'La langue est obligatoire.',
            'id_langue.exists' => 'La langue sélectionnée n\'existe pas.',

            // Messages pour photo
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou webp.',
            'photo.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        $newPhotoUrl = null;
        $oldPhotoPublicId = null;

        try {
            // Préparer les données à mettre à jour
            $dataToUpdate = [
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'sexe' => $validated['sexe'],
                'date_naissance' => $validated['date_naissance'],
                'id_langue' => $validated['id_langue'],
            ];

            // ✅ Gestion de l'upload avec CLOUDINARY
            if ($request->hasFile('photo')) {
                try {
                    // Extraire le public_id de l'ancienne photo Cloudinary si elle existe
                    if ($user->photo && str_contains($user->photo, 'cloudinary')) {
                        // Extraire le public_id depuis l'URL Cloudinary
                        // Format URL: https://res.cloudinary. com/CLOUD_NAME/image/upload/v123456/profiles/profile_123. jpg
                        preg_match('/\/profiles\/([^\/]+)/', $user->photo, $matches);
                        if (isset($matches[1])) {
                            // Enlever l'extension
                            $oldPhotoPublicId = 'profiles/' . pathinfo($matches[1], PATHINFO_FILENAME);
                        }
                    }

                    $cloudinary = new \Cloudinary\Cloudinary();

                    // Upload la nouvelle photo
                    $result = $cloudinary->uploadApi()->upload(
                        $request->file('photo')->getRealPath(),
                        [
                            'folder' => 'profiles',
                            'public_id' => 'profile_' . $user->id .  '_' . time(),
                            'resource_type' => 'image',
                            'transformation' => [
                                'width' => 400,
                                'height' => 400,
                                'crop' => 'fill',
                                'gravity' => 'face',
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]
                    );

                    $newPhotoUrl = $result['secure_url'];
                    $dataToUpdate['photo'] = $newPhotoUrl;

                    Log::info('Photo de profil mise à jour sur Cloudinary', [
                        'user_id' => $user->id,
                        'new_url' => $newPhotoUrl,
                        'old_public_id' => $oldPhotoPublicId,
                    ]);

                    // Supprimer l'ancienne photo de Cloudinary après l'upload réussi
                    if ($oldPhotoPublicId) {
                        try {
                            $cloudinary->uploadApi()->destroy($oldPhotoPublicId);
                            Log::info('Ancienne photo supprimée de Cloudinary', [
                                'public_id' => $oldPhotoPublicId,
                            ]);
                        } catch (\Exception $deleteException) {
                            // Ne pas bloquer si la suppression échoue
                            Log::warning('Échec de suppression de l\'ancienne photo', [
                                'public_id' => $oldPhotoPublicId,
                                'error' => $deleteException->getMessage(),
                            ]);
                        }
                    }

                } catch (\Exception $uploadException) {
                    Log::error('Erreur upload photo Cloudinary', [
                        'user_id' => $user->id,
                        'error' => $uploadException->getMessage(),
                    ]);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Erreur lors de l\'upload de l\'image : ' . $uploadException->getMessage());
                }
            }

            // ✅ Mettre à jour les informations utilisateur
            $user->update($dataToUpdate);

            Log::info('Profil utilisateur mis à jour', [
                'user_id' => $user->id,
                'updated_fields' => array_keys($dataToUpdate),
            ]);

            return redirect()->route('profile.edit')
                ->with('success', 'Votre profil a été mis à jour avec succès !  ');

        } catch (\Exception $e) {
            // ✅ En cas d'erreur, supprimer la nouvelle photo uploadée sur Cloudinary
            if ($newPhotoUrl) {
                try {
                    preg_match('/\/profiles\/([^\/]+)/', $newPhotoUrl, $matches);
                    if (isset($matches[1])) {
                        $newPhotoPublicId = 'profiles/' . pathinfo($matches[1], PATHINFO_FILENAME);

                        $cloudinary = new \Cloudinary\Cloudinary();
                        $cloudinary->uploadApi()->destroy($newPhotoPublicId);

                        Log::info('Nouvelle photo supprimée après erreur', [
                            'public_id' => $newPhotoPublicId,
                        ]);
                    }
                } catch (\Exception $deleteException) {
                    Log::error('Échec suppression photo après erreur', [
                        'error' => $deleteException->getMessage(),
                    ]);
                }
            }

            Log::error('Erreur mise à jour profil', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil.  Veuillez réessayer.');
        }
    }
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        // Validation UNIQUEMENT des champs du formulaire de mot de passe
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'current_password. required' => 'Le mot de passe actuel est obligatoire.',
            'current_password. current_password' => 'Le mot de passe actuel est incorrect.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        try {
            $user = Auth::user();

            // Mettre à jour UNIQUEMENT le mot de passe
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('profile.edit')->with('success', 'Votre mot de passe a été modifié avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la modification du mot de passe. Veuillez réessayer.');
        }
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
