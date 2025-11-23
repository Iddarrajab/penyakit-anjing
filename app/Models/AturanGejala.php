<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanGejala extends Model
{
    use HasFactory;

    protected $table = 'aturan_gejala';

    protected $fillable = [
        'aturan_id',
        'gejala_id',
        'cf',
    ];

    // Relasi ke tabel Aturan
    public function aturan()
    {
        return $this->belongsTo(Aturan::class);
    }

    // Relasi ke tabel Gejala
    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
