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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('duration')->comment('1->1day,7=>1week,14=>1week,30->monthly');
            $table->double('price', 8, 2)->nullable();
            $table->tinyInteger('daily_ride')->nullable();
            $table->tinyInteger('total_ride')->nullable();
            $table->boolean('status')->default(true)->comment('1=>active,0=>inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
