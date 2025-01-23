<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslationRequest extends FormRequest
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
            'locale' => 'required|string|max:10',
            'key' => 'required|string|max:255|unique:translations,key,' . $this->route('id'),
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ];
    }
}
