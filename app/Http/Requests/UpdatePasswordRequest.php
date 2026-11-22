<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'password'         => ['required', 'string', 'confirmed', Password::min(6)],
        ];
    }

    /**
     * Use a named error bag so both forms on the same page show errors independently.
     */
    protected function getRedirectUrl(): string
    {
        return $this->redirector->getUrlGenerator()->route('account.profile');
    }

    /**
     * @return string
     */
    protected function errorBag(): string
    {
        return 'password';
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'current_password.required'      => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required'              => 'Password baru wajib diisi.',
            'password.confirmed'             => 'Konfirmasi password baru tidak cocok.',
            'password.min'                   => 'Password baru minimal terdiri dari :min karakter.',
        ];
    }
}
