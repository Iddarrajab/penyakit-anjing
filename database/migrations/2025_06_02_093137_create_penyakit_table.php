<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id(); // Kolom id (auto increment)
            $table->string('code')->unique(); // Kolom kode penyakit yang harus unik
            $table->string('penyakit')->unique(); // Nama penyakit, bisa null
            $table->text('solusi')->nullable(); // Solusi, bisa null
            $table->text('obat')->nullable(); // Obat, bisa null
            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
