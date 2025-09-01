<?php

namespace App\Http\Requests\Api\v1\ClientAuth;

use Illuminate\Foundation\Http\FormRequest;

class checkPhone extends FormRequest
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
            'phone' => ['required', 'string', 'exists:clients,phone']
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required' => __('validation.required', ['attribute' => __('attributes.phone')]),
            'phone.phone'    => __('validation.phone', ['attribute' => __('attributes.phone')]),
            'phone.exists'   => __('validation.exists', ['attribute' => __('attributes.phone')]),
        ];
    }
}
