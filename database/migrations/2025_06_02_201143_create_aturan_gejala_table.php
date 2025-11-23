<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('aturan_gejala', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel aturan
            $table->unsignedBigInteger('aturan_id');
            $table->foreign('aturan_id')
                ->references('id')
                ->on('aturan')
                ->onDelete('cascade');

            // Relasi ke tabel gejala
            $table->unsignedBigInteger('gejala_id');
            $table->foreign('gejala_id')
                ->references('id')
                ->on('gejala')
                ->onDelete('cascade');

            // Nilai certainty factor dari pakar (0.0 - 1.0)
            $table->decimal('cf_pakar', 4, 2)->default(0.0);

            // Opsional: bobot gejala (bisa digunakan untuk decision tree)
            $table->integer('urutan')->nullable()->comment('Posisi atau prioritas gejala dalam decision tree');

            $table->timestamps();

            // Agar kombinasi aturan-gejala unik
            $table->unique(['aturan_id', 'gejala_id']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_gejala');
    }
};
