<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            $table->string('option_text'); // e.g., '< 1 Juta', 'Terbatas'
            $table->integer('weight'); // The numeric value for this sub-criteria
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sub_criterias');
    }
};