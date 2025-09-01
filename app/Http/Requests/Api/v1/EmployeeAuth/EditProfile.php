<?php

namespace App\Http\Requests\Api\v1\EmployeeAuth;

use App\Rules\Media;
use Illuminate\Foundation\Http\FormRequest;

class EditProfile extends FormRequest
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
        return [
            "name"              => ["sometimes", "string", "max:255"],
            "phone"             => ["sometimes", "string", "max:15", "regex:/^([0-9\s\-\+\(\)]*)$/"],
            'photo'             => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            "email"             => ["sometimes", "string", "email", "max:255", "unique:users,email," . auth()->id()],
            'job_title'         => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                     => "The name field is required.",
            'name.string'                       => "The name must be a string.",
            'name.max'                          => "The name may not be greater than 255 characters.",

            'email.required'                    => "The email field is required.",
            'email.string'                      => "The email must be a string.",
            'email.email'                       => "The email must be a valid email address.",
            'email.unique'                      => "The email has already been taken.",

            'phone.required'                    => "The phone field is required.",
            'phone.string'                      => "The phone must be a string.",
            'phone.max'                         => "The phone may not be greater than 15 characters.",
            'phone.regex'                       => "The phone format is invalid.",

            'photo.required'                    => "The photo field is required.",
            'photo.image'                       => "The photo must be an image.",
            'photo.mimes'                       => "The photo must be a file of type: jpeg, png, jpg, gif, svg.",
            'photo.max'                         => "The photo may not be greater than 2048 kilobytes.",

            'job_title.required'                => "The job title field is required.",
            'job_title.string'                  => "The job title must be a string.",
            'job_title.max'                     => "The job title may not be greater than 255 characters.",


        ];
    }
}
