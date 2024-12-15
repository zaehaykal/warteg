<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('subpesanan', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('menu_id'); // Nama menu
            $table->string('foto')->nullable()->after('nama'); // Foto menu (URL path atau nama file)
            $table->string('kategori')->nullable()->after('foto'); // Kategori menu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('subpesanan', function (Blueprint $table) {
            $table->dropColumn(['nama', 'foto', 'kategori']);
        });
    }
};
