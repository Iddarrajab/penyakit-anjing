<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: tambahkan constraint unique.
     */
    public function up(): void
    {
        Schema::table('aturan', function (Blueprint $table) {
            $table->unique('penyakit_id', 'aturan_penyakit_id_unique');
        });
    }

    /**
     * Reverse migration: hapus constraint unique.
     */
    public function down(): void
    {
        Schema::table('aturan', function (Blueprint $table) {
            $table->dropUnique('aturan_penyakit_id_unique');
        });
    }
};
