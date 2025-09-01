<?php

namespace App\Http\Requests\Api\v1\ClientAuth;

use Illuminate\Foundation\Http\FormRequest;

class CheckCode extends FormRequest
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
            'code' => ['required', 'exists:clients,code']
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
            'code.required' => __('validation.required', ['attribute' => __('attributes.code')]),
            'code.exists'   => __('validation.exists', ['attribute' => __('attributes.code')]),
        ];
    }
}
