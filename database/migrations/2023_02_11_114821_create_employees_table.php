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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('admission_date')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('identification');
            $table->string('social_security');
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('occupation_area')->nullable();
            $table->string('ein')->nullable();
            $table->string('corporate_name')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->string('cnai')->nullable();
            $table->string('photo')->nullable();
            $table->string('tshirt')->nullable();
            $table->string('trousers')->nullable();
            $table->string('shoe')->nullable();
            $table->text('observation')->nullable();
            $table->string('work_card')->nullable();
            $table->string('reservist')->nullable();
            $table->string('voter_registration')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_identification')->nullable();
            $table->string('spouse_social_security')->nullable();
            $table->string('spouse_birth_date')->nullable();
            $table->string('contract')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
