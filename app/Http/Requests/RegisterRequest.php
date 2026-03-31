<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * All API users are allowed to register.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for registration.
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.max'      => 'First name may not exceed 100 characters.',
            'last_name.required'  => 'Last name is required.',
            'last_name.max'       => 'Last name may not exceed 100 characters.',
            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please provide a valid email address.',
            'email.unique'        => 'The email has already been taken.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'The password must be at least 8 characters.',
            'password.confirmed'  => 'Password confirmation does not match.',
        ];
    }
}
