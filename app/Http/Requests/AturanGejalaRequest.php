<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AturanGejalaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tidak menggunakan policy, jadi semua user yang memiliki akses ke halaman ini diperbolehkan
        return true;
    }

    public function rules(): array
    {
        $aturanId = $this->input('aturan_id');
        $gejalaId = $this->input('gejala_id');

        return [
            'aturan_id' => [
                'required',
                'integer',
                'exists:aturan,id',
            ],
            'gejala_id' => [
                'required',
                'integer',
                'exists:gejala,id',
                // Pastikan kombinasi aturan_id + gejala_id unik di tabel pivot
                Rule::unique('aturan_gejala')->where(
                    fn($query) =>
                    $query->where('aturan_id', $aturanId)
                )->ignore($this->id),
            ],
            'cf' => [
                'required',
                'numeric',
                'between:0,1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'aturan_id.required' => 'Kolom aturan wajib dipilih.',
            'aturan_id.integer' => 'Kolom aturan tidak valid.',
            'aturan_id.exists' => 'Aturan tidak ditemukan dalam database.',

            'gejala_id.required' => 'Kolom gejala wajib dipilih.',
            'gejala_id.integer' => 'Kolom gejala tidak valid.',
            'gejala_id.exists' => 'Gejala tidak ditemukan dalam database.',
            'gejala_id.unique' => 'Kombinasi aturan dan gejala ini sudah ada.',

            'cf.required' => 'Nilai CF (Certainty Factor) wajib diisi.',
            'cf.numeric' => 'Nilai CF harus berupa angka desimal.',
            'cf.between' => 'Nilai CF harus berada antara 0 dan 1.',
        ];
    }
}
