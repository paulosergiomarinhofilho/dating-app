<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [

                'name'          =>  'string',
                'password'      =>  'min:8',
                'birthdate'     =>  'date',
                'gender'        =>  'string',
                'sexual_orientation'    =>  'string',
                'target_gender' => 'string',
                'show_as_gender' => 'string',
                'max_distance' => 'integer',
                'age_min' => 'integer',
                'age_max' => 'integer',
                'age_max' => 'integer',
                'description_disability' => 'string',
        ];
    }
}
