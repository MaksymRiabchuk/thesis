<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'email|required|max:255|string|unique:users,email',
            'password' => 'required|min:8|confirmed|max:255|string',
            'name' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Email is invalid',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must be less than 255 characters',
            'password.confirmed' => 'Password does not match',
            'name.required' => 'Name is required',
            'name.max' => 'Name must be less than 255 characters',
        ];
    }
}
