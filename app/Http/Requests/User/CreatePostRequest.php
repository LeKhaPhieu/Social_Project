<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'category' => 'required',
            'title' => 'required|max:255',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'mimes' => __('validation.mimes'),
            'max:2048' => __('validation.max_2048'),
        ];
    }
}
