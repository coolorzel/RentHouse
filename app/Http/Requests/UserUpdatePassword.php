<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Illuminate\Validation\Rules;

class UserUpdatePassword extends FormRequest
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
        return [
            'oldPassword' => ['required','string','min:8'],
            'newPassword' => ['required',Rules\Password::defaults()],
            'repPassword' => ['required','same:newPassword'],
        ];
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]));
    }
}
