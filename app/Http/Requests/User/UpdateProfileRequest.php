<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'user_name' => 'required|min:5|max:255|regex:/^[a-zA-Z0-9]+$/|unique:users,user_name,'. auth()->id(),
            'gender' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'required|numeric|unique:users,phone_number,' . auth()->id(),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute' . __('validation.required'),
            'max' => ':attribute' . __('validation.max:255'),
            'min' => ':attribute' . __('validation.min:5'),
            'unique' => ':attribute' . __('validation.unique'),
            'numeric' => ':attribute' . __('validation.numeric'),
            'regex' => ':attribute' . __('validation.rule_username'),
            'mimes' => __('validation.mimes'),
            'max:2048' => __('validation.max_2048'),
        ];
    }
    public function attributes(): array
    {
        return [
            'username' => __('validation.username'),
            'email' => __('validation.email'),
            'password' => __('validation.password'),
            'phone_number' => __('validation.phone'),
        ];
    }
}
