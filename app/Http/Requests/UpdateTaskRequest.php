<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'sometimes|string|regex:/[a-zA-Z]/|max:50',
            'description' => 'sometimes|string|nullable',
            'priority' => 'integer|between:1,10',
        ];
    }
    public function messages()
    {
        return [
            'title.regex' => 'The title field must be only string',
            'title.max' => 'The title field must not exceed 50 characters',
            'priority.integer' => 'The priority field must be integer',
            'priority.between' => 'The priority field must be between 1 and 10 .',
        ];
    }
}
