<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Aturan;

class AturanRequest extends FormRequest
{
    protected ?Aturan $aturan = null;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->aturan = $this->route('aturan');
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('aturan', 'code')->ignore($this->aturan?->id),
            ],
            'penyakit_id' => [
                'required',
                'integer',
                'exists:penyakit,id',
            ],
            'gejala_ids' => ['required', 'array', 'min:1'],
            'gejala_ids.*' => ['integer', 'exists:gejala,id'],
            'cf' => ['required', 'array'],
            'cf.*' => ['numeric', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode aturan wajib diisi.',
            'code.unique' => 'Kode aturan sudah digunakan.',
            'penyakit_id.required' => 'Pilih penyakit terlebih dahulu.',
            'gejala_ids.required' => 'Pilih minimal satu gejala.',
            'cf.required' => 'Nilai CF wajib diisi.',
            'cf.*.between' => 'Nilai CF harus antara 0.0 hingga 1.0.',
        ];
    }
}
