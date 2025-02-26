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
        Schema::create('zaehler_arten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('art');
            $table->string('caption');
            $table->unsignedInteger('einheit_id');
            $table->foreign('einheit_id')->references('id')->on('einheits');
            $table->string('sort_reihenfolge');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zaehler_arten');
    }
};
