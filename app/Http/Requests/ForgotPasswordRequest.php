<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute' . __('validation.required'),
            'email' => ':attribute' . __('validation.email_address'),
            'exists' => ':attribute' . __('validation.exists'),
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('validation.email'),
        ];
    }
}
