<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('user_preferences'); // Stores selected sub_criteria_ids for each criteria
            $table->json('calculated_rankings'); // Stores the final top 5 rankings
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('calculation_histories');
    }
};