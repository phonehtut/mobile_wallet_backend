<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MerchantSubmitRequest extends FormRequest
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
            'shop_name' => 'required|string|max:255',
            'shop_url' => 'nullable|string|max:255',
            'shop_logo' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'address' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $api = new BaseController();

        $response = $api->validationError($validator->errors()->messages());

        throw new HttpResponseException($response);
    }
}
