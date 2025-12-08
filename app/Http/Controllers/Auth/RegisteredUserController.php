<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Langue;
use App\Models\User;
use Cloudinary\Cloudinary; // ✅ Import direct
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $langues = Langue::all();
        return view('auth.register', compact('langues'));
    }

    public function store(Request $request): RedirectResponse
    {
        // ✅ Validation complète
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-ZÀ-ÿ\s\-]+$/u'],
            'prenom' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-ZÀ-ÿ\s\-]+$/u'],
            'sexe' => ['required', 'string', 'in:masculin,feminin'],
            'date_naissance' => [
                'required',
                'date',
                'before:today',
                function ($attribute, $value, $fail) {
                    $age = date_diff(date_create($value), date_create('today'))->y;
                    if ($age < 13) {
                        $fail('Vous devez avoir au moins 13 ans pour vous inscrire.');
                    }
                }
            ],
            'langue_id' => ['required', 'integer', 'exists:langues,id'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                'unique:' . User::class,
                'regex:/^[a-zA-Z0-9. _%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/' // ✅ Sans espaces
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if (! $value) return;

                    $image = getimagesize($value->getPathname());
                    if (! $image) {
                        $fail('Impossible de lire les dimensions de l\'image.');
                        return;
                    }

                    $width = $image[0];
                    $height = $image[1];

                    if ($width > 2000 || $height > 2000) {
                        $fail('Les dimensions de l\'image ne peuvent pas dépasser 2000x2000 pixels.');
                    }

                    $ratio = $width / $height;
                    if ($ratio < 0.7 || $ratio > 1.3) {
                        $fail('L\'image doit avoir un format carré ou proche du carré.');
                    }
                }
            ],
            'terms' => ['required', 'accepted'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'nom.regex' => 'Le nom ne peut contenir que des lettres, espaces et tirets.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom. min' => 'Le prénom doit contenir au moins 2 caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'prenom.regex' => 'Le prénom ne peut contenir que des lettres, espaces et tirets.',

            'sexe.required' => 'Veuillez sélectionner votre sexe.',
            'sexe.in' => 'Le sexe sélectionné est invalide.',

            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',

            'langue_id.required' => 'Veuillez sélectionner votre langue principale.',
            'langue_id. exists' => 'La langue sélectionnée est invalide.',

            'email. required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.lowercase' => 'L\'adresse email doit être en minuscules.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'email.regex' => 'Le format de l\'adresse email est invalide.',

            'password. required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password. min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',

            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou WEBP.',
            'photo. max' => 'L\'image ne peut pas dépasser 2 Mo.',

            'terms.required' => 'Vous devez accepter les conditions d\'utilisation.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        $photoUrl = null;
        $cloudinaryPublicId = null;

        try {
            // ✅ UPLOAD CLOUDINARY - Exactement comme votre code équipement
            if ($request->hasFile('photo')) {
                if ($request->file('photo')->getSize() > 2 * 1024 * 1024) {
                    return back()->withErrors([
                        'photo' => 'L\'image ne peut pas dépasser 2 Mo.'
                    ])->withInput();
                }

                try {
                    $cloudinary = new Cloudinary();

                    $result = $cloudinary->uploadApi()->upload(
                        $request->file('photo')->getRealPath(),
                        [
                            'folder' => 'profiles',
                            'public_id' => 'profile_' .  time() . '_' . $validated['email'],
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

                    $photoUrl = $result['secure_url']; // ✅ Stocke le lien direct
                    $cloudinaryPublicId = $result['public_id'];

                    Log::info('Photo uploaded to Cloudinary', [
                        'url' => $photoUrl,
                        'public_id' => $cloudinaryPublicId,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Cloudinary upload error', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);

                    return back()
                        ->withErrors([
                            'photo' => 'Erreur lors de l\'upload de l\'image : ' . $e->getMessage()
                        ])
                        ->withInput();
                }
            }

            // ✅ Création de l'utilisateur
            $user = User::create([
                'nom' => ucfirst(strtolower(trim($validated['nom']))),
                'prenom' => ucfirst(strtolower(trim($validated['prenom']))),
                'sexe' => $validated['sexe'],
                'date_naissance' => $validated['date_naissance'],
                'id_langue' => $validated['langue_id'],
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'photo' => $photoUrl,
                'email_verified_at' => null,
            ]);

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            // ✅ Envoi email (sans bloquer)
            $emailSent = false;
            try {
                event(new Registered($user));
                $emailSent = true;

                Log::info('Email de vérification envoyé', [
                    'user_id' => $user->id,
                ]);
            } catch (\Exception $emailException) {
                Log::error('Email failed', [
                    'user_id' => $user->id,
                    'error' => $emailException->getMessage(),
                ]);

                session()->flash('warning', 'Votre compte a été créé avec succès mais l\'email de vérification n\'a pas pu être envoyé.');
            }

            // ✅ Connexion
            Auth::login($user);

            // ✅ Redirection
            if ($emailSent) {
                return redirect()->route('verification.notice')
                    ->with('success', 'Votre compte a été créé avec succès !  Veuillez vérifier votre email.');
            } else {
                return redirect()->route('dashboard')
                    ->with('warning', 'Votre compte a été créé mais l\'email de vérification n\'a pas pu être envoyé.');
            }

        } catch (\Exception $e) {
            // ✅ Supprimer la photo Cloudinary en cas d'erreur
            if ($cloudinaryPublicId) {
                try {
                    $cloudinary = new Cloudinary();
                    $cloudinary->uploadApi()->destroy($cloudinaryPublicId);

                    Log::info('Photo deleted after error', [
                        'public_id' => $cloudinaryPublicId,
                    ]);
                } catch (\Exception $deleteException) {
                    Log::error('Failed to delete photo', [
                        'public_id' => $cloudinaryPublicId,
                        'error' => $deleteException->getMessage(),
                    ]);
                }
            }

            // ✅ Log erreur
            Log::error('Erreur lors de l\'inscription', [
                'email' => $request->email ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $errorMessage = 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.';

            if (config('app.debug')) {
                $errorMessage .= ' Détails: ' . $e->getMessage();
            }

            return back()
                ->withErrors(['email' => $errorMessage])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
