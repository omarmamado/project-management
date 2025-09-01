<?php

namespace App\Http\Requests\Api\v1\ClientAuth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            'new_password' => ['required', 'min:8', 'confirmed'],
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

            'new_password.required'     => __('validation.required', ['attribute' => __('attributes.new_password')]),
            'new_password.min'          => __('validation.min', ['attribute' => __('attributes.new_password'), 'min' => 8]),
            'new_password.confirmed'    => __('validation.confirmed', ['attribute' => __('attributes.new_password')]),
        ];
    }
}
