<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable()->change();
            $table->string('license_plate')->nullable()->change();
            $table->unsignedBigInteger('job_id')->nullable()->change();
            $table->unsignedBigInteger('shift_id')->nullable()->change();
            $table->unsignedBigInteger('manufacture_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable()->change();
            $table->string('license_plate')->nullable()->change();
            $table->unsignedBigInteger('job_id')->nullable()->change();
            $table->unsignedBigInteger('shift_id')->nullable()->change();
            $table->unsignedBigInteger('manufacture_id')->nullable()->change();
        });
    }
}
