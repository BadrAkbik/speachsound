<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->json('words');
            $table->enum('for', ['test', 'training'])->default('training');
            $table->foreignId('sound_id')->constrained('sounds')->cascadeOnDelete();
            $table->foreignId('training_id')->nullable()->constrained('trainings')->cascadeOnDelete();
            $table->foreignId('test_id')->nullable()->constrained('tests')->cascadeOnDelete();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
