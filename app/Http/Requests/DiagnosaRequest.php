<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosaRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini
     */
    public function authorize(): bool
    {
        return true; // Ubah jika kamu ingin validasi hak akses user
    }

    /**
     * Aturan validasi
     */
    public function rules(): array
    {
        return [
            'nama_hewan' => 'required|string|max:100',
            'gejala' => 'required|array',
            'gejala.*' => 'exists:gejala,id',
        ];
    }

    /**
     * Pesan validasi opsional (bisa dikustomisasi)
     */
    public function messages(): array
    {
        return [
            'nama_hewan.required' => 'Nama hewan wajib diisi.',
            'gejala.required' => 'Pilih minimal satu gejala.',
            'gejala.*.exists' => 'Gejala yang dipilih tidak valid.',
        ];
    }
}
