<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aturan_gejala', function (Blueprint $table) {
            $table->float('cf')->default(1.0)->after('gejala_id');
        });
    }

    public function down(): void
    {
        Schema::table('aturan_gejala', function (Blueprint $table) {
            $table->dropColumn('cf');
        });
    }
};
