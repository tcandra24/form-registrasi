<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationMechanicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_mechanics', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->string('fullname');
            $table->string('no_hp');
            $table->string('workshop_name');
            $table->text('address');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_scan')->default(false);
            $table->dateTime('scan_date')->nullable();
            $table->string('event_slug');
            $table->string('token');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_mechanics');
    }
}
