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
            if (Schema::hasColumn('articles', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Tambahkan kembali kolom 'slug' jika rollback
            // Asumsikan itu string dan nullable. Sesuaikan jika migrasi asli memiliki spesifikasi berbeda.
            if (!Schema::hasColumn('articles', 'slug')) {
                $table->string('slug')->nullable()->after('title'); // Sesuaikan 'after' jika diperlukan
            }
        });
    }
};