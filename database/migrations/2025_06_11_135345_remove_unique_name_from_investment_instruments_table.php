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
        Schema::table('investment_instruments', function (Blueprint $table) {
            // Pastikan indeks unik 'name' ada sebelum dihapus
            $table->dropUnique(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_instruments', function (Blueprint $table) {
            // Tambahkan kembali batasan unik jika rollback
            $table->unique('name');
        });
    }
};