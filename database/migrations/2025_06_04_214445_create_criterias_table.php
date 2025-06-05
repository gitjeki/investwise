<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // C1, C2, C3, etc.
            $table->string('name');
            $table->enum('type', ['benefit', 'cost']); // For SMART calculation
            $table->string('question')->nullable(); // For user preference question
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};