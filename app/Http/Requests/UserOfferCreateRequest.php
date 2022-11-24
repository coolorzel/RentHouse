<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserOfferCreateRequest extends FormRequest
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
        if ($_POST['btn'] == 'add') {
            return [
                'name' => 'required',
                'description' => 'required|min:20|max:500',
                'rooms' => 'int',
                'surface' => 'int',
                'land_area' => 'int',
                'regular_rent' => 'int',
                'sale_rent' => 'int',
                'deposit' => 'int',
            ];
        }else{
            return [];
        }
    }
    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]));
    }
}
