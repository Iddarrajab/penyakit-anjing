<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosa_gejala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnosa_id');
            $table->unsignedBigInteger('gejala_id');
            $table->float('cf', 4, 2)->nullable();
            $table->timestamps();

            $table->foreign('diagnosa_id')
                ->references('id')->on('diagnosa')
                ->onDelete('cascade');

            $table->foreign('gejala_id')
                ->references('id')->on('gejala')
                ->onDelete('cascade');

            $table->unique(['diagnosa_id', 'gejala_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosa_gejala');
    }
};
