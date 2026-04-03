<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'PERD_EMER'              => ['required', 'string', 'max:100'],
            'PERD_MBIEMER'           => ['required', 'string', 'max:100'],
            'PERD_EMAIL'             => ['required', 'email', 'unique:PERDORUES,PERD_EMAIL'],
            'PERD_FJKALIM'           => ['required', 'string', 'min:8', 'confirmed'],
            'PERD_FJKALIM_confirmation' => ['required'],
            'PERD_TIPI'              => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'PERD_EMER.required'     => 'First name is required.',
            'PERD_EMER.max'          => 'First name may not exceed 100 characters.',
            'PERD_MBIEMER.required'  => 'Last name is required.',
            'PERD_MBIEMER.max'       => 'Last name may not exceed 100 characters.',
            'PERD_EMAIL.required'    => 'Email address is required.',
            'PERD_EMAIL.email'       => 'Please provide a valid email address.',
            'PERD_EMAIL.unique'      => 'This email has already been taken.',
            'PERD_FJKALIM.required'  => 'Password is required.',
            'PERD_FJKALIM.min'       => 'Password must be at least 8 characters.',
            'PERD_FJKALIM.confirmed' => 'Password confirmation does not match.',
            'PERD_TIPI.required'     => 'User type is required.',
        ];
    }
}
