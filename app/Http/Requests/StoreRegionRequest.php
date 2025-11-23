<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
            'nom_region'         => 'required|string|max:150|unique:regions,nom_region',
            'description_region' => 'nullable|string|max:500',
            'population'         => 'required|integer|min:0',
            'superficie'         => 'required|numeric|min:0',
            'localisation'       => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nom_region.required' => 'Le nom de la région est obligatoire.',
            'nom_region.unique'   => 'Ce nom de région existe déjà.',

            'population.required' => 'La population est obligatoire.',
            'population.integer'  => 'La population doit être un nombre entier.',

            'superficie.required' => 'La superficie est obligatoire.',
            'superficie.numeric'  => 'La superficie doit être une valeur numérique.',
            'localisation.required' => 'la localisation est requise',
        ];
    }
}
