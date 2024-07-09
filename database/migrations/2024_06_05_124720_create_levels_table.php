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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->unique()->nullable();
            $table->string('name_en')->unique()->nullable();
            $table->foreignId('age_group_id')->nullable()->constrained('age_groups')->nullOnDelete();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('success_rate', 2)->nullable();
            $table->integer('attemtps_count')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
