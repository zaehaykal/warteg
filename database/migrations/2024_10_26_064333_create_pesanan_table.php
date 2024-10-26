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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id'); // foreign key untuk tabel pengguna
            
            $table->decimal('total_harga', 10, 2);
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->timestamps();

            // Set foreign key yang merujuk ke tabel 'pengguna'
            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            
        });
        
        Schema::dropIfExists('pesanan');
    }
};
