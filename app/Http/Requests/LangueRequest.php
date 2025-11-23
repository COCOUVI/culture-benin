<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LangueRequest extends FormRequest
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
            //
            'nom_langue' => 'required|unique:langues,nom_langue',
             'code_langue' => 'required|unique:langues,code_langue',
            'description_langue' => 'nullable',
        ];
    }
    public function messages(): array{
        return [
            'nom_langue.required' => 'Le nom de la langue est obligatoire.',
             'code_langue.required' => 'Le code de la langue est obligatoire.',
            'nom_langue.unique' => 'le nom de cette langue existe deja',
            'code_langue.unique' => 'le code de cette langue existe deja',
        ] ;
    }
}
