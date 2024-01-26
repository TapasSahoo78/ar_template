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
        Schema::create('driver_running_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->nullable()->unsigned()->references('id')->on('buses')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->unsigned()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_running_histories');
    }
};
