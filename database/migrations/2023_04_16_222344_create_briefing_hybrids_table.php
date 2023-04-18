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
        Schema::create('briefing_hybrids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('briefing_id')->constrained('briefings');
            $table->string('armchair')->nullable();
            $table->string('armchair_quantity')->nullable();
            $table->string('armchair_description')->nullable();
            $table->string('pulpit')->nullable();
            $table->string('pulpit_quantity')->nullable();
            $table->string('pulpit_description')->nullable();
            $table->string('table')->nullable();
            $table->string('table_quantity')->nullable();
            $table->string('table_description')->nullable();
            $table->string('lounge')->nullable();
            $table->string('lounge_quantity')->nullable();
            $table->string('lounge_description')->nullable();
            $table->string('others')->nullable();
            $table->string('others_description')->nullable();
            $table->string('screen')->nullable();
            $table->string('lighting_decorative')->nullable();
            $table->string('lighting_foyer')->nullable();
            $table->string('lighting_restaurant')->nullable();
            $table->string('lighting_stage')->nullable();
            $table->string('lighting_audience')->nullable();
            $table->string('lighting_effects')->nullable();
            $table->string('sound_room')->nullable();
            $table->string('sound_foyer')->nullable();
            $table->string('sound_restaurant')->nullable();
            $table->string('microphone_quantity')->nullable();
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
            $table->string('teleprompter')->nullable();
            $table->string('teleprompter_quantity')->nullable();
            $table->string('ipad')->nullable();
            $table->string('ipad_quantity')->nullable();
            $table->string('ipad_description')->nullable();
            $table->string('studio_local')->nullable();
            $table->string('studio_room')->nullable();
            $table->string('studio_amount')->nullable();
            $table->string('studio_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefing_hybrids');
    }
};
