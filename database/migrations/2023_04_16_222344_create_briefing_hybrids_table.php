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
            $table->tinyInteger('armchair')->default(0);
            $table->integer('armchair_quantity')->nullable();
            $table->text('armchair_description')->nullable();
            $table->tinyInteger('pulpit')->default(0);
            $table->integer('pulpit_quantity')->nullable();
            $table->text('pulpit_description')->nullable();
            $table->tinyInteger('table')->default(0);
            $table->text('table_description')->nullable();
            $table->tinyInteger('lounge')->default(0);
            $table->text('lounge_description')->nullable();
            $table->text('others')->nullable();
            $table->text('screen')->nullable();
            $table->tinyInteger('lighting_decorative')->default(0);
            $table->tinyInteger('lighting_foyer')->default(0);
            $table->tinyInteger('lighting_restaurant')->default(0);
            $table->tinyInteger('lighting_stage')->default(0);
            $table->tinyInteger('lighting_effects')->default(0);
            $table->tinyInteger('sound_room')->default(0);
            $table->tinyInteger('sound_foyer')->default(0);
            $table->tinyInteger('sound_restaurant')->default(0);
            $table->integer('microphone_quantity')->nullable();
            $table->tinyInteger('translation')->default(0);
            $table->text('translation_comments')->nullable();
            $table->text('languages')->nullable();
            $table->integer('radio_quantity')->nullable();
            $table->string('name_interpreter')->nullable();
            $table->string('phone_interpreter')->nullable();
            $table->string('platform_transmission')->nullable();
            $table->string('link_event')->nullable();
            $table->string('site_landing')->nullable();
            $table->string('social_network')->nullable();
            $table->tinyInteger('speaker')->default(0);
            $table->integer('speaker_quantity')->nullable();
            $table->text('speaker_description')->nullable();
            $table->tinyInteger('speaker_studio')->default(0);
            $table->integer('speaker_studio_quantity')->nullable();
            $table->text('speaker_studio_description')->nullable();
            $table->tinyInteger('direction')->default(0);
            $table->integer('direction_quantity')->nullable();
            $table->text('direction_description')->nullable();
            $table->string('rehearsal')->nullable();
            $table->string('rehearsal_address')->nullable();
            $table->string('recording')->nullable();
            $table->string('recording_address')->nullable();
            $table->tinyInteger('teleprompter')->default(0);
            $table->integer('teleprompter_quantity')->nullable();
            $table->tinyInteger('ipad')->default(0);
            $table->string('ipad_quantity')->nullable();
            $table->text('ipad_description')->nullable();
            $table->text('transmission_description')->nullable();
            $table->string('studio_local')->nullable();
            $table->string('studio_room')->nullable();
            $table->integer('studio_speakers_quantity')->nullable();
            $table->string('studio_type')->nullable();
            $table->text('additionals')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
