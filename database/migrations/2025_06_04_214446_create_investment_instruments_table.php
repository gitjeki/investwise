<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_instruments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Deposito, Emas, Obligasi
            $table->string('type')->nullable(); // e.g., Berjangka, Batang / Digital, SBR
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('investment_instruments');
    }
};