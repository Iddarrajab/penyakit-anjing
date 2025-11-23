<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id auto increment
            $table->string('name'); // nama user
            $table->string('email')->unique(); // email unik
            $table->timestamp('email_verified_at')->nullable(); // verifikasi email
            $table->string('password'); // password
            $table->string('telepon')->nullable(); // nomor telepon opsional
            $table->rememberToken(); // token untuk "remember me"
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
