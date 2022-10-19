<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstInstallValidationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name_settings' => [
                'required',
                'max:191',
            ],
            'response' => [
                'array',
                'required',
                'max:191',
            ],
            'response.*' => [
                'required',
                'max:191',
                'string',
            ],
            '_step' => [
                'required',
            ],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'response.*.required' => 'test',
        ];
    }
}
