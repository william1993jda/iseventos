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
        Schema::create('order_service_check_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_service_check_id')->constrained('order_service_checks');
            $table->bigInteger('order_service_room_product_id')->unsigned();
            $table->foreign('order_service_room_product_id', 'os_room_product_id_foreign')->references('id')->on('order_service_room_products');
            $table->foreignId('os_product_id')->constrained('os_products');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('os_product_stock_id')->nullable()->constrained('os_product_stocks');
            $table->date('checkout_date')->nullable();
            $table->date('checkin_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service_check_items');
    }
};
