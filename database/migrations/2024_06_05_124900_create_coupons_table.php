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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('start');
            $table->date('end');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('uses_limit');
            $table->integer('uses_count')->default(0);
            $table->enum('type', ['amount', 'percentage']);
            $table->float('value', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
