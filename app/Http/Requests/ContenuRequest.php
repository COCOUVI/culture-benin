<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContenuRequest extends FormRequest
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
        return [
            'titre' => ['required', 'string', 'min:3', 'max:255'],
            'texte' => ['nullable', 'string'],
            'statut' => ['required', Rule::in(['actif', 'inactif'])],
            'region_id' => ['required', 'exists:regions,id'],
            'langue_id' => ['required', 'exists:langues,id'],
            'type_contenu_id' => ['required', 'exists:type_contenus,id'],
            'id_auteur' => ['required', 'exists:users,id'],

        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.min' => 'Le titre doit contenir au moins :min caractères.',
            'titre.max' => 'Le titre ne peut pas dépasser :max caractères.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit être "actif" ou "inactif".',
            'region_id.required' => 'Veuillez sélectionner une région.',
            'region_id.exists' => 'La région sélectionnée est invalide.',
            'langue_id.required' => 'Veuillez sélectionner une langue.',
            'langue_id.exists' => 'La langue sélectionnée est invalide.',
            'type_contenu_id.required' => 'Veuillez sélectionner un type de contenu.',
            'type_contenu_id.exists' => 'Le type de contenu sélectionné est invalide.',
            'id_auteur.required' => 'Veuillez sélectionner un auteur.',
            'id_auteur.exists' => 'L\'auteur sélectionné est invalide.',
        ];
    }
}
