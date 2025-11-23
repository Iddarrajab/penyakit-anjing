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
        Schema::create('decision_tree', function (Blueprint $table) {
            $table->id();

            // Kode node unik (misal: N01, N02, dst)
            $table->string('kode_node')->unique();

            // Node induk (parent), null = root node
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('decision_tree')
                ->onDelete('cascade');

            // Kondisi cabang dari parent (ya/tidak)
            $table->enum('kondisi', ['ya', 'tidak'])->nullable();

            // Relasi ke gejala yang diuji di node ini
            $table->unsignedBigInteger('gejala_id')->nullable();
            $table->foreign('gejala_id')
                ->references('id')
                ->on('gejala')
                ->onDelete('set null');

            // Relasi ke penyakit jika ini leaf node
            $table->unsignedBigInteger('penyakit_id')->nullable();
            $table->foreign('penyakit_id')
                ->references('id')
                ->on('penyakit')
                ->onDelete('cascade');

            // Nilai Certainty Factor dari pakar
            $table->decimal('cf_pakar', 4, 2)->nullable()->default(1.0);

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('decision_tree');
    }
};
