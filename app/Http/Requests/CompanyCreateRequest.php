<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyCreateRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name'),
            ],
            'address' => 'bail|required|string|max:255',
            'industry' => 'bail|required|string|max:255',
            'website' => 'nullable|string|url|max:255',

            // owner details
            'owner_name' => 'bail|required|string|max:255',
            'owner_email' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email')
            ],
            'owner_password' => 'bail|required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Company name field is required.',
            'name.unique' => 'The Company name is already been taken.',
            'name.max' => 'The Company name may not be greater than 255 characters.',
            'name.string' => 'The Company name must be a string.',
            'address.required' => 'The Company address field is required.',
            'address.max' => 'The Company address may not be greater than 255 characters.',
            'address.string' => 'The Company address must be a string.',
            'industry.required' => 'The Company industry field is required.',
            'industry.max' => 'The Company industry may not be greater than 255 characters.',
            'industry.string' => 'The Company industry must be a string.',
            'website.url' => 'The Company website must be a valid URL.',
            'website.max' => 'The Company website may not be greater than 255 characters.',
            'website.string' => 'The Company website must be a string.',

            // owner details
            'owner_name.required' => 'The Owner name field is required.',
            'owner_name.max' => 'The Owner name may not be greater than 255 characters.',
            'owner_name.string' => 'The Owner name must be a string.',
            'owner_email.required' => 'The Owner email field is required.',
            'owner_email.unique' => 'The Owner email is already been taken.',
            'owner_email.max' => 'The Owner email may not be greater than 255 characters.',
            'owner_email.string' => 'The Owner email must be a string.',
            'owner_password.required' => 'The Owner password field is required.',
            'owner_password.min' => 'The Owner password must be at least 8 characters.',
        ];
    }
}
