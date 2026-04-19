<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobCategoryUpdateRequest extends FormRequest
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
                Rule::unique('job_categories', 'name')->ignore($this->route('job_category')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Category name field is required.',
            'name.unique' => 'The Category name is already been taken.',
            'name.max' => 'The Category name may not be greater than 255 characters.',
            'name.string' => 'The Category name must be a string.',
        ];
    }
}
