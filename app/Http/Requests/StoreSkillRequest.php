<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
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
            'name' => 'required|unique:skills,name,' . ($this->skill ? $this->skill->id : null),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The skill name is required.',
            'name.unique' => 'This skill already exists.',
        ];
    }
}