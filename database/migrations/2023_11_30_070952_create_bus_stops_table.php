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
        Schema::create('bus_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->index()->references('id')->on('routes')->after('id');
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('location')->nullable();
            $table->decimal('longitude', 10, 6)->nullable()->comment('Longitude coordinate');
            $table->decimal('latitude', 10, 6)->nullable()->comment('Latitude coordinate');
            $table->integer('order_column')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0=>not-active, 1=>Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_stops');
    }
};
