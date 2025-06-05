<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternative_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained('investment_instruments')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->integer('score'); // The Cout_i value for this instrument on this criteria
            $table->timestamps();

            $table->unique(['instrument_id', 'criteria_id']); // Each instrument has one score per criteria
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('alternative_scores');
    }
};