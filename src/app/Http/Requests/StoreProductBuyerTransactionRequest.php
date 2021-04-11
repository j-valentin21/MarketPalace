<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductBuyerTransactionRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 422,
            'message' => 'Bad Validation',
            'errors' => [
                "stock", [
                    "The stock field is required.",
                    "The stock field must be an integer",
                     "The stock field must have a minimum value of 1"
                ],
            ]
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
