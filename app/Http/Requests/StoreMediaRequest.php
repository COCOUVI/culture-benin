<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
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
        $rules = [
            'description'   => 'nullable|string|max:500',
            'id_contenu'    => 'required|exists:contenus,id',
            'id_type_media' => 'required|exists:type_medias,id',
        ];

        // Si c'est la création (store), chemin est obligatoire
        if ($this->isMethod('post')) {
            $rules['chemin'] = 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:102400';
        }

        // Si c'est update, chemin devient facultatif
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['chemin'] = 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:102400';
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'chemin.required' => 'Veuillez sélectionner un fichier.',
            'chemin.file'     => 'Le fichier est invalide.',
            'chemin.max'      => 'Le fichier ne doit pas dépasser 20MB.',
            'chemin.mimes'    => 'Seuls les fichiers jpg, jpeg, png, gif, mp4, mov et avi sont autorisés.',

            'description.string' => 'La description doit être un texte valide.',
            'description.max'    => 'La description ne doit pas dépasser 500 caractères.',

            'id_contenu.required' => 'Veuillez choisir un contenu.',
            'id_contenu.exists'   => 'Le contenu sélectionné est introuvable.',

            'id_type_media.required' => 'Veuillez choisir un type de média.',
            'id_type_media.exists'   => 'Le type de média sélectionné est invalide.',
        ];
    }

}
