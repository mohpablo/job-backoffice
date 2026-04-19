<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends FormRequest
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
        $companyId = $this->route('company') ?? $this->route('id');

        return [
            'name' => [
                'bail',
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($companyId),
            ],
            'address' => 'bail|required|string|max:255',
            'industry' => 'bail|required|string|max:255',
            'website' => 'nullable|string|url|max:255',
            'owner_password' => 'bail|nullable|string|min:8',
            'owner_name' => 'bail|required|string|max:255',
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
            'owner_password.required' => 'The Company owner password field is required.',
            'owner_password.min' => 'The Company owner password must be at least 8 characters.',
            'owner_name.required' => 'The Company owner name field is required.',
            'owner_name.max' => 'The Company owner name may not be greater than 255 characters.',
            'owner_name.string' => 'The Company owner name must be a string.',
        ];
    }
}
