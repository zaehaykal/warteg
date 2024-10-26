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
        Schema::create('subpesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('menu_id'); // foreign key untuk tabel menu
            $table->string('nama_menu');
            $table->integer('quantity');
            $table->integer('harga');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            // Foreign key relationship ke tabel 'pesanan'
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['pesanan_ids']);
            $table->dropForeign(['menu_id']);
            
        });
        
        Schema::dropIfExists('subpesanan');
    }
};
