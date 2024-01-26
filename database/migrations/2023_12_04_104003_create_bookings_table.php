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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('route_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bus_id')->nullable()->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('route_id')->nullable()->references('id')->on('routes')->onDelete('cascade');
            $table->foreignId('bus_stop_id')->nullable()->references('id')->on('bus_stops')->constrained()->cascadeOnDelete();

            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('booking_no')->nullable();

            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->tinyInteger('is_validate')->default(0)->comment('0=>no, 1=>yes');
            $table->tinyInteger('status')->default(0)->comment('0=>waitting, 1=>onGoing, 2=>canceled, 3=>completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
