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
        Schema::create('business_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->boolean('monday')->default(true);
            $table->boolean('tuesday')->default(true);
            $table->boolean('wednesday')->default(true);
            $table->boolean('thursday')->default(true);
            $table->boolean('friday')->default(true);
            $table->boolean('saturday')->default(true);
            $table->boolean('sunday')->default(true);
            $table->foreign('business_id')->references('id')->on('new_businesses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_times');
    }
};
