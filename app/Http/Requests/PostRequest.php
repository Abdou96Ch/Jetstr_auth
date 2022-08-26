<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Les règles d'erreur
        return [
            'title' => 'required|min:3|max:100', 
            'body' => 'required|min:5|max:100', 
            // Verifier dans la route si le slug existe alors le champ est non obligatoire
            'image'=> $this->route('slug') ? 'image|max:2048': 'required|image|mimes:png|max:2048'
        ];
    }
}
