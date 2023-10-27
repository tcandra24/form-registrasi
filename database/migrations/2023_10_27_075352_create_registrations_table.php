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
            $table->string('fullname');
            $table->string('no_hp');
            $table->string('vehicle_type');
            $table->string('license_plate');
            $table->boolean('is_scan')->default(false);
            $table->dateTime('scan_date')->nullable();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('shift_id')->references('id')->on('shifts');
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
        Schema::dropIfExists('registrations');
    }
}
