<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';
    protected $fillable = ['code', 'gejala'];

    public function aturan()
    {
        return $this->belongsToMany(Aturan::class, 'aturan_gejala')
            ->withPivot('cf')
            ->withTimestamps();
    }
}
