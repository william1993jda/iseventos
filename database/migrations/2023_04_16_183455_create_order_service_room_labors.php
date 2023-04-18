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
        Schema::create('order_service_room_labors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_service_id')->constrained('order_services');
            $table->foreignId('place_room_id')->constrained('place_rooms');
            $table->foreignId('labor_id')->constrained('labors');
            $table->string('days');
            $table->string('quantity');
            $table->double('price', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service_room_labors');
    }
};
