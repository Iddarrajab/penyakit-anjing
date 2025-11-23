<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;

    protected $table = 'aturan';

    protected $fillable = ['code', 'penyakit_id'];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id');
    }

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'aturan_gejala', 'aturan_id', 'gejala_id')
            ->withPivot('cf')
            ->withTimestamps();
    }
}
