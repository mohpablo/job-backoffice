<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobApplicationUpdataRequset extends FormRequest
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
            "status" => 'bail|required|in:Pending,Accepted,Rejected'
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Job Status is required',
            'status.in' => 'Job Status is invalid'
        ];
    }
}
