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
        Schema::create('last_searches', function (Blueprint $table) {
            $table->id();
            $table->string('search')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('lat')->nullable();
            $table->string('longi')->nullable();
            $table->string('city')->nullable();
            $table->string('cat_id')->nullable();
            $table->string('sub_cat_id')->nullable();
            $table->string('state')->nullable();
            $table->text('agent')->nullable();
            $table->string('ip')->nullable();
            $table->text('bot_type')->nullable();
            $table->boolean('bot')->default(false);
            $table->text('link')->nullable();
            $table->integer('device_type')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_searches');
    }
};
