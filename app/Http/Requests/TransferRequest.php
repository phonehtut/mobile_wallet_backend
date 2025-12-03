<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver_id' => 'required|integer|exists:users,id',
            'amount' => 'required|integer|min:1000',
            'note' => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $api = new BaseController();

        $response = $api->validationError($validator->errors()->messages());

        throw new HttpResponseException($response);
    }
}
