<?php

namespace App\Http\Requests\Api\v1\ClientAuth;

use Illuminate\Foundation\Http\FormRequest;

class ChangeNotificaion extends FormRequest
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
            'show_notification' => ['required', 'boolean', 'in:0,1'],
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

            'new_password.required'     => __('validation.required', ['attribute' => __('attributes.show_notification')]),
            'new_password.boolean'          => __('validation.boolean', ['attribute' => __('attributes.show_notification'), 'min' => 8]),
            'new_password.in'    => __('validation.in', ['attribute' => __('attributes.show_notification')]),
        ];
    }
}
