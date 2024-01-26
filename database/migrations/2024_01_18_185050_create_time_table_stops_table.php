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
        Schema::create('time_table_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->unsigned()->references('id')->on('routes')->constrained()->cascadeOnDelete();
            $table->foreignId('bus_id')->unsigned()->references('id')->on('buses')->constrained()->cascadeOnDelete();
            $table->enum('week_days', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'])->nullable();
            $table->foreignId('bus_stop_id')->unsigned()->references('id')->on('bus_stops')->constrained()->cascadeOnDelete();
            $table->string('bus_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_table_stops');
    }
};
