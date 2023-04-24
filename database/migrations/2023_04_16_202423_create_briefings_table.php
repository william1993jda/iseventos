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
        Schema::create('briefings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('local');
            $table->tinyInteger('type_event')->default(1);
            $table->string('company');
            $table->string('email');
            $table->string('phone');
            $table->date('start_date_mount')->nullable();
            $table->date('end_date_mount')->nullable();
            $table->date('start_date_rehearsal')->nullable();
            $table->date('end_date_rehearsal')->nullable();
            $table->date('start_date_event')->nullable();
            $table->date('end_date_event')->nullable();
            $table->string('public')->nullable();
            $table->string('bu')->nullable();
            $table->string('focal_point')->nullable();
            $table->string('agency_name')->nullable();
            $table->string('agency_contact')->nullable();
            $table->string('agency_phone')->nullable();
            $table->string('agency_email')->nullable();
            $table->tinyInteger('agency_production')->default(0);
            $table->tinyInteger('agency_criation')->default(0);
            $table->tinyInteger('agency_logistic')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefings');
    }
};
