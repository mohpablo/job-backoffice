<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => ['bail', 'required', 'string', 'max:255'],
            'location' => ['bail', 'required', 'string', 'max:255'],
            'salary' => ['bail', 'required', 'numeric', 'min:0'],
            'type' => ['bail', 'required', 'max:255'],
            'description' => ['bail', 'required', 'string'],
            'jobcategoryId' => ['bail', 'required', 'exists:job_categories,id'],
            'companyId' => ['bail', 'required', 'exists:companies,id']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'salary.required' => 'The salary field is required.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',
            'type.required' => 'The type field is required.',
            'type.max' => 'The type may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'jobcategoryId.required' => 'The job category field is required.',
            'jobcategoryId.exists' => 'The job category does not exist.',
            'companyId.required' => 'The company field is required.',
            'companyId.exists' => 'The company does not exist.',
        ];
    }
}
