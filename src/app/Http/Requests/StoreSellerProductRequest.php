<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSellerProductRequest extends FormRequest
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
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 422,
            'message' => 'Bad Validation',
            'errors' => [
                "title", [
                    "The title field is required.",
                ],
                "details", [
                    "The details field is required.",
                ],
                "stock", [
                    "The stock field is required.",
                    "The stock field must be an integer",
                    "The stock field must have a minimum value of 1"
                ],
                "image", [
                    "The image field is required.",
                    "The image field must be an image",
                ],
            ]
        ];

        throw new HttpResponseException(response()->json($response, 400));
    }
}
