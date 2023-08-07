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
        Schema::table('budget_room_products', function (Blueprint $table) {
            $table->unsignedBigInteger('place_room_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_room_products', function (Blueprint $table) {
            $table->unsignedBigInteger('place_room_id')->nullable(false)->change();
        });
    }
};
