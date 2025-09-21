<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TranslationFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:50'],
            'namespace' => ['nullable', 'string', 'max:50'],
            //Values for the Key
            'values' => ['required', 'array'],
            'values.*.language_code' => ['required', 'string', 'max:5'],
            'values.*.value' => ['required', 'string', 'max:50'],
            'values.*.tag' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'language_code.required' => 'The language code field is required.',
            'language_code.max' => 'May not be greater than 50 characters.',
            'key.required' => 'The key field is required.',
            'key.max' => 'The key may not be greater than 50 characters.',
            'namespace.max' => 'May not be greater than 50 characters.',
            'values.required' => 'At least one value is required.',
            'values.*.value.required' => 'The value field is required.',
            'values.*.language_code.required' => 'The language code field is required.',
            'values.*.value.max' => 'May not be greater than 50 characters.',
            'values.*.tag.max' => 'May not be greater than 50 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
