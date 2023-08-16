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
        Schema::create('sublease_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sublease_id')->constrained('subleases');
            $table->foreignId('os_product_id')->constrained('os_products');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('provider_id')->nullable()->constrained('providers');
            $table->integer('quantity');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sublease_items');
    }
};
