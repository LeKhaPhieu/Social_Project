<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'user_name' => 'required|min:5|max:255|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'required|max:11',
            'gender' => 'required|in:' . implode(',', User::getGenders()),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute' . __('validation.required'),
            'max' => ':attribute' . __('validation.max:255'),
            'min' => ':attribute' . __('validation.min:3'),
            'email' => ':attribute' . __('validation.email_address'),
            'unique' => ':attribute' . __('validation.unique'),
            'confirmed' => ':attribute' . __('validation.confirmed'),
            'numeric' => ':attribute' . __('validation.numeric'),
            'in' => ':attribute' . __('validation.in'),
        ];
    }
    public function attributes(): array
    {
        return [
            'username' => __('validation.username'),
            'email' => __('validation.email'),
            'password' => __('validation.password'),
            'phone' => __('validation.phone'),
            'password_confirmation' => __('validation.password_confirmation'),
        ];
    }
}
