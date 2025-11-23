<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Récupère l'utilisateur courant depuis la route
        $user = $this->route('user');

        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'date_naissance' => ['required', 'date'], // désormais requis
            'sexe' => ['required', 'in:masculin,feminin'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'id_role' => ['required', 'exists:roles,id'],
            'id_langue' => ['required', 'exists:langues,id'],
            'statut' => ['required', 'in:actif,inactif'],
            'password' => ['nullable', 'string', 'min:6'], // plus de confirmation
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être valide.",
            'email.unique' => "Cet email est déjà utilisé par un autre utilisateur.",
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.in' => 'Le sexe doit être Masculin ou Féminin.',
            'photo.image' => 'La photo doit être une image valide.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'id_role.required' => 'Le rôle est obligatoire.',
            'id_role.exists' => 'Le rôle sélectionné est invalide.',
            'id_langue.required' => 'La langue est obligatoire.',
            'id_langue.exists' => 'La langue sélectionnée est invalide.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit être Actif ou Inactif.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ];
    }
}
