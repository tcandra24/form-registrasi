<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->string('fullname');
            $table->string('no_hp');
            $table->string('vehicle_type');
            $table->string('license_plate');
            $table->boolean('is_scan')->default(false);
            $table->boolean('is_vip')->default(false);
            $table->dateTime('scan_date')->nullable();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('manufacture_id');
            $table->string('token');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->foreign('manufacture_id')->references('id')->on('manufactures');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
