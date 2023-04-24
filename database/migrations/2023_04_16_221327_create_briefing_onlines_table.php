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
            $table->string('platform_transmission')->nullable();
            $table->string('link_event')->nullable();
            $table->string('site_landing')->nullable();
            $table->string('social_network')->nullable();
            $table->tinyInteger('speaker')->default(0);
            $table->string('speaker_quantity')->nullable();
            $table->text('speaker_description')->nullable();
            $table->tinyInteger('direction')->default(0);
            $table->string('direction_quantity')->nullable();
            $table->text('direction_description')->nullable();
            $table->tinyInteger('rehearsal')->default(0);
            $table->string('rehearsal_address')->nullable();
            $table->tinyInteger('recording')->default(0);
            $table->string('recording_address')->nullable();
            $table->tinyInteger('translation')->default(0);
            $table->text('translation_comments')->nullable();
            $table->text('languages')->nullable();
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
        Schema::dropIfExists('briefing_onlines');
    }
};
