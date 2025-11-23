<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Penyakit;

class PenyakitRequest extends FormRequest
{
    protected ?Penyakit $penyakit = null;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Ambil model dari route model binding (kalau ada)
        $this->penyakit = $this->route('penyakit');
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('penyakit', 'code')->ignore($this->penyakit?->id),
            ],
            'penyakit' => [
                'required',
                'string',
                'max:55',
                Rule::unique('penyakit', 'penyakit')->ignore($this->penyakit?->id),
            ],
            'solusi' => 'required|string',
            'obat' => 'required|string',
        ];
    }
}
