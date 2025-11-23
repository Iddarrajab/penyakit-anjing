<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';
    protected $fillable = ['code', 'penyakit', 'solusi', 'obat'];

    public function aturan()
    {
        return $this->hasMany(Aturan::class);
    }

    // Jika ingin akses gejala dari penyakit via aturan, gunakan accessor:
    public function gejala()
    {
        // Ini bukan relasi, tapi method custom untuk mengambil data gejala terkait
        return Gejala::whereHas('aturan', function ($query) {
            $query->where('penyakit_id', $this->id);
        })->get();
    }
}
