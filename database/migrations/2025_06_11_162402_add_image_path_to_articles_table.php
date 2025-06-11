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
        Schema::table('articles', function (Blueprint $table) {
            // Tambahkan kolom 'image_path' untuk menyimpan nama file gambar
            $table->string('image_path')->nullable()->after('body'); // Setelah kolom 'body'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Hapus kolom 'image_path' jika rollback
            $table->dropColumn('image_path');
        });
    }
};