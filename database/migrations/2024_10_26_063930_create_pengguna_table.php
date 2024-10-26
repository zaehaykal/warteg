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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nohp');
            $table->string('alamat');
            $table->string('foto');
            $table->string('email');
            $table->string('password');
            // $table->unsignedBigInteger('pesanan_id'); // kolom pesanan sebagai FK
            // $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade'); // FK mengacu ke 'pesanan'
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table('pengguna', function (Blueprint $table) {
        //     // Menghapus foreign key terlebih dahulu
        //     $table->dropForeign(['pesanan']);
        // });

        // Menghapus tabel 'pengguna'
        Schema::dropIfExists('pengguna');
    }
};
