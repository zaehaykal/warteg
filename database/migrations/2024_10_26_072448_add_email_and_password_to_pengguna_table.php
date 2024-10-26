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
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('email')->unique()->after('foto'); // Menambahkan kolom email
            $table->string('password')->after('email'); // Menambahkan kolom password
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['email', 'password']); // Menghapus kolom email dan password
        });
    }
};
