<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
        $id = $this->request->get('user_id');

        return [
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 422,
            'message' => 'Bad Validation',
            'errors' => [
                "email" , [
                    'The email must be unique'
                ],
                "password", [
                    "password must have at least 6 characters"
                ]
            ]
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
