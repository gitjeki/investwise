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
            // Periksa apakah kolom 'image' ada sebelum menghapusnya.
            // Ini untuk menghindari error jika kolom sudah tidak ada.
            if (Schema::hasColumn('articles', 'image')) {
                $table->dropColumn('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Tambahkan kembali kolom 'image' jika rollback (misalnya, untuk keperluan debugging atau jika ini adalah kolom asli)
            // Asumsikan itu adalah string dan nullable. Sesuaikan jika migrasi asli Anda memiliki spesifikasi berbeda.
            if (!Schema::hasColumn('articles', 'image')) {
                 $table->string('image')->nullable()->after('category'); // Sesuaikan 'after' jika diperlukan
            }
        });
    }
};