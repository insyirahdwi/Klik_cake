<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\s\-()]+$/'],
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
        return 'profile';
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max'      => 'Nama maksimal 100 karakter.',
            'phone.regex'   => 'Format nomor telepon tidak valid.',
            'phone.max'     => 'Nomor telepon maksimal 20 karakter.',
        ];
    }
}
