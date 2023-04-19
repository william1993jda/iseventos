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
        Schema::create('briefing_onlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('briefing_id')->constrained('briefings');
            $table->string('translation')->nullable();
            $table->string('languages')->nullable();
            $table->string('amount_radio')->nullable();
            $table->string('description_translation')->nullable();
            $table->string('recommendation_translation')->nullable();
            $table->string('name_interpreter')->nullable();
            $table->string('phone_interpreter')->nullable();
            $table->string('additional_description')->nullable();
            $table->string('observation_description')->nullable();
            $table->string('platform_transmission')->nullable();
            $table->string('link_event')->nullable();
            $table->string('site_landing')->nullable();
            $table->string('social_network')->nullable();
            $table->string('speaker')->nullable();
            $table->string('speaker_quantity')->nullable();
            $table->string('speaker_description')->nullable();
            $table->string('artistic_direction')->nullable();
            $table->string('direction_quantity')->nullable();
            $table->string('direction_description')->nullable();
            $table->string('rehearsal')->nullable();
            $table->string('rehearsal_address')->nullable();
            $table->string('recording')->nullable();
            $table->string('recording_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefing_onlines');
    }
};
