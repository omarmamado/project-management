<?php

namespace App\Http\Requests\Api\v1\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashRequest extends FormRequest
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
            'request_name'      => ['required', 'string' , 'max:255'],
            'reason'            => ['required', 'string'],
            'due_date'          => ['required', 'date'],
            'amount'            => ['required', 'numeric'],
            'cash_category_id'  => ['required', 'exists:cash_categories,id'],
            'attachment'        => ['nullable', 'file'],
             'items'            => ['nullable', 'array'],
            'items.*.item_name' => ['required', 'string'],
            'items.*.price'     => ['required', 'numeric'],
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'request_name.required'     => 'Request name is required',
            'reason.required'           => 'Reason is required',
            'due_date.required'         => 'Due date is required',
            'amount.required'           => 'Amount is required',
            'cash_category_id.required' => 'Cash category is required',
            'attachment.file'           => 'Attachment must be a file',
            'items.array'               => 'Items must be an array',
            'items.*.item_name.required'=> 'Item name is required',
            'items.*.price.required'    => 'Price is required',
        ];
    }
}
