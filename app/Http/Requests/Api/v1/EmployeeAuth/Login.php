<?php

namespace App\Http\Requests\Api\v1\EmployeeAuth;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
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
            "email"             => ["required", "email" , "max:255"],
            'password'          => ['required', 'string'],
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
            'phone.required'            => __('validation.required', ['attribute' => __('attributes.phone')]),
            'phone.phone'               => __('validation.phone', ['attribute' => __('attributes.phone')]),
            'phone.max'                 => __('validation.max.string', ['attribute' => __('attributes.phone'), 'max' => 11]),

            'password.required'         => __('validation.required', ['attribute' => __('attributes.password')]),
            'password.min'              => __('validation.min', ['attribute' => __('attributes.password'), 'min' => 8]),
            'password.string'           => __('validation.string', ['attribute' => __('attributes.password')]),
        ];
    }
}
