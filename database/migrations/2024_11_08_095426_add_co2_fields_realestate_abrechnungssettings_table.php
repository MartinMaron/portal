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
        Schema::table('abrechnungssettings', function($table)
        {
            $table->boolean('co2_kennzeichen_WEG')->nullable();
            $table->boolean('co2_wohngeb')->nullable();
            $table->boolean('co2_kennzeichen_1_9')->nullable();
            $table->boolean('co2_kennzeichen_2_9')->nullable();
            $table->boolean('co2_anschluss_nach_2022')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
