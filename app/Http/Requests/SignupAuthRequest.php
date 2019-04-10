<?php

namespace Pheaks\Http\Requests;

use Pheaks\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class SignupAuthRequest extends Request
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
        return [
            'first_name'=> 'required',
            'last_name' => 'required',
            'user_name' => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'birth_day' => 'required',
            'birth_month'=>'required',
            'birth_year'=> 'required',
            'password'  => 'required',
            'sex'       => 'required',
            'interest'  => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => 'The email is required',
            'unique'    => ':attribute already been used.'
        ];
    }
}
