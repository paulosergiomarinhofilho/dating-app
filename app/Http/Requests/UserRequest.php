<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
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
}
