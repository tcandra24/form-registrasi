<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNullableRegistrationMechanic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registration_mechanics', function (Blueprint $table) {
            $table->string('workshop_name')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_mechanics', function (Blueprint $table) {
            $table->string('workshop_name')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }
}
