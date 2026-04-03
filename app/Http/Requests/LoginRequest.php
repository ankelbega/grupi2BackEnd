<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'PERD_EMAIL'   => ['required', 'email'],
            'PERD_FJKALIM' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'PERD_EMAIL.required'   => 'Email address is required.',
            'PERD_EMAIL.email'      => 'Please provide a valid email address.',
            'PERD_FJKALIM.required' => 'Password is required.',
        ];
    }
}
