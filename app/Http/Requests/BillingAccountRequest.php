<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BillingAccountRequest extends FormRequest
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
        $validate['company'] = ['required', 'boolean'];
        if($_POST['company'] == true) {
            $validate = [
                'name' => 'bail|required',
                'lname' => 'required',
                'pesel' => 'int|required',
                'phone_number' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'street' => 'required',
                'building_number' => 'required',
                'company_name' => 'required',
                'company_nip' => 'required',
                'company_website' => 'max:30',
                'message' => 'max:254',
            ];
        }else{
            $validate = [
                'name' => 'bail|required',
                'lname' => 'required',
                'pesel' => 'int|required',
                'phone_number' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'street' => 'required',
                'building_number' => 'required',
                'message' => 'max:254',
            ];
        }
        return $validate;
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]));
    }
}
