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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('customer_contact_id')->nullable()->constrained('customer_contacts');
            $table->foreignId('agency_id')->nullable()->constrained('agencies');
            $table->foreignId('place_id')->nullable()->constrained('places');
            $table->integer('budget_number');
            $table->integer('budget_version')->default(1);
            $table->string('name');
            $table->date('request_date');
            $table->string('budget_days');
            $table->date('mount_date')->nullable();
            $table->date('unmount_date')->nullable();
            $table->string('public')->nullable();
            $table->text('observation')->nullable();
            $table->float('discount', 8, 2)->nullable();
            $table->enum('discount_type', ['percent', 'money'])->nullable();
            $table->string('commercial_conditions')->nullable();
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
        Schema::dropIfExists('budgets');
    }
};
