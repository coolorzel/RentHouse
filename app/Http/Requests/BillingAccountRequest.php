<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

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
                'pesel' => 'PESEL',
                'phone_number' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'zipcode' => 'post_code',
                'street' => 'required',
                'building_number' => 'required',
                'company_name' => 'required',
                'company_nip' => 'NIP',
                'company_regon' => 'required',
                'company_website' => 'max:30',
                'message' => 'max:254',
            ];
        }else{
            $validate = [
                'name' => 'bail|required',
                'lname' => 'required',
                'pesel' => 'PESEL',
                'phone_number' => 'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'zipcode' => 'post_code',
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
