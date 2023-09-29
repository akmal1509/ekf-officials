<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
        // Validator::extend('without_spaces', function ($attr, $value) {
        //     return preg_match('/^\S*$/u', $value);
        // });
        return [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|regex:/^[^\s]+$/'
        ];
    }
    public function messages()
    {
        return [
            'newPassword.regex' => 'Password tidak boleh mengandung spasi.',
            'oldPassword.required' => 'Password lama harus diisi',
            'newPassword.required' => 'Password baru harus diisi',
            'newPassword.min' => 'Password baru minimal 8 karakter'
        ];
    }
}
