<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
    public function rules()
    {
        return [

                'name'          =>  'required',
                'password'      =>  'required|min:8',
                'birthdate'     =>  'required|date',
                'gender'        =>  'nullable',
                'sexual_orientation'    =>  'nullable',
                'target_gender' => 'required',
                'max_distance' => 'nullable',
                'age_min' => 'nullable',
                'age_max' => 'nullable',
                'age_max' => 'nullable',
                'description_disability' => 'nullable',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->withoutTrashed()
                ],
        ];
    }

    public function messages()
    {
        return [
            'birthdate.required' => 'O campo data de nascimento é obrigatório.',
            'birthdate.date' => 'O campo data de nascimento deve ser uma data válida.',
            'name.required' => 'O campo de nome é obrigatório.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.min' => 'O campo de senha precisa contar 8 ou mais caracteres.',
        ];
    }
}
