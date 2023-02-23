<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('os_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('os_product_id')->constrained('os_products');
            $table->string('sku')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->string('accessories')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('life_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('os_product_stocks');
    }
};
