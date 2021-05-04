<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    public $validator = null;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 422,
            'message' => 'Bad Validation',
            'errors' => [
                "name", [ "The name field is required."],
                "email" , [
                    "The email field is required.",
                    'The email must be unique'
                ],
                "password", [
                    "password field is required",
                    "password must have at least 6 characters"
                ]
            ]
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
