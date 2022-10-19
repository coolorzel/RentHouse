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

class UserProfileValidationRequest extends FormRequest
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

        $user = User::find(Auth::user()->id)->first();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => ['required','unique:users,username,'.$user->id],
            'province' => ['required'],
            'city' => [''],
            'zipcode' => [''],
            'street' => [''],
            'number' => [''],
            'country' => [''],
            'phone' => [''],
        ];

        if (isset($_POST['password']))
        {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        if (isset($_POST['email']))
        {
            $rules['email'] = ['required','email:rfc,dns','unique:users,email,'.$user->id];
        }
        return $rules;
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]));
    }
}
