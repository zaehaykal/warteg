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
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('total_harga'); // Ganti `kolom_terakhir` dengan nama kolom terakhir pada tabel Anda
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('pesanan', function (Blueprint $table) {
        if (Schema::hasColumn('pesanan', 'status')) {
            $table->dropColumn('status');
        }
    });
}

};
