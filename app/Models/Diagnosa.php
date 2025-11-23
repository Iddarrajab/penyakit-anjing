<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosa';

    protected $fillable = [
        'user_id',
        'nama_hewan',
        'penyakit_id',
        'nilai_cf',
    ];

    /**
     * Relasi ke tabel users (user yang melakukan diagnosa)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel penyakit
     */
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id');
    }

    /**
     * Relasi ke tabel gejala melalui tabel pivot diagnosa_gejala
     */
    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'diagnosa_gejala')
            ->withPivot('cf')
            ->withTimestamps();
    }
}
