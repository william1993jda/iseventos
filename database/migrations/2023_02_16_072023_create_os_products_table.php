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
        Schema::create('os_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('os_category_id')->constrained('os_categories');
            $table->foreignId('provider_id')->nullable()->constrained('providers');
            $table->string('name');
            $table->boolean('customization');
            $table->double('price', 8, 2);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serie')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('weight')->nullable();
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
        Schema::dropIfExists('os_products');
    }
};
