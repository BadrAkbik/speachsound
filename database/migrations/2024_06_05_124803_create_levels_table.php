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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->json('words');
            $table->foreignId('sound_id')->constrained('sounds')->cascadeOnDelete();
            $table->string('audio')->nullable();
            $table->string('xray_video')->nullable();
            $table->string('natural_video')->nullable();
            $table->float('success_rate', 2)->nullable();
            $table->integer('success_attempts')->nullable();
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
