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
        Schema::create('driver_activites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unsigned()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('bus_id')->nullable()->unsigned()->references('id')->on('buses')->constrained()->cascadeOnDelete();
            $table->foreignId('route_id')->nullable()->unsigned()->references('id')->on('routes')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->unsigned()->references('id')->on('drivers')->constrained()->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=>pending, 1=>success, 2=>cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_activites');
    }
};
