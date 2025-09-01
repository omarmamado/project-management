<?php

namespace App\Http\Requests\Api\v1\ClientAuth;

use App\Rules\Media;
use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            "name"              => ["required", "string", "max:255"],
            "email"             => ["required", "string", "email", "max:255", "unique:users,email"],
            "password"          => ["required", "string", "min:8" , "confirmed"],
            "phone"             => ["required", "string", "max:15", "regex:/^([0-9\s\-\+\(\)]*)$/"],
        ];

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'             => __('validation.required', ['attribute' => __('attributes.name')]),
            'name.string'               => __('validation.string', ['attribute' => __('attributes.name')]),
            'name.max'                  => __('validation.max', ['attribute' => __('attributes.name'), 'max' => 255]),

            'email.required'           => __('validation.required', ['attribute' => __('attributes.email')]),
            'email.string'             => __('validation.string', ['attribute' => __('attributes.email')]),
            'email.email'              => __('validation.email', ['attribute' => __('attributes.email')]),
            'email.unique'             => __('validation.unique', ['attribute' => __('attributes.email')]),

            'password.required'        => __('validation.required', ['attribute' => __('attributes.password')]),
            'password.string'          => __('validation.string', ['attribute' => __('attributes.password')]),
            'password.min'             => __('validation.min', ['attribute' => __('attributes.password'), 'min' => 8]),

            'phone.required'           => __('validation.required', ['attribute' => __('attributes.phone')]),
            'phone.string'             => __('validation.string', ['attribute' => __('attributes.phone')]),
            'phone.max'                => __('validation.max', ['attribute' => __('attributes.phone'), 'max' => 11]),
            'phone.regex'              => __('validation.regex', ['attribute' => __('attributes.phone')]),

        ];
    }
}
