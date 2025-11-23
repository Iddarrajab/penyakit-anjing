<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true; // request selalu diizinkan
    }

    /**
     * Aturan validasi untuk permintaan ini.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $userId = $this->user ? $this->user->id : null;

        $passwordRule = $this->isMethod('post')
            ? 'required|string|min:6|confirmed'
            : 'nullable|string|min:6|confirmed';

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email' . ($userId ? ',' . $userId : ''),
            'telepon'  => 'nullable|string|max:20',
            'password' => $passwordRule,
        ];
    }
}
